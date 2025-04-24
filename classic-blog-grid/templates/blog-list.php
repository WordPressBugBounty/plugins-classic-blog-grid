<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit 

$posts_per_page = get_post_meta($post_id, '_clbgd_posts_per_page', true);

$posts_per_page = $posts_per_page ? $posts_per_page : 5;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 

$show_date = $meta_values['show_date'];
$show_author = $meta_values['show_author'];
$show_comments = $meta_values['show_comments'];
$show_excerpt = $meta_values['show_excerpt'];
$excerpt_length = $meta_values['excerpt_length'] ?: 15; 

$show_categories = $meta_values['show_categories'];
$enable_featured_image = $meta_values['enable_featured_image'];
$show_social_share = $meta_values['show_social_share'];
//show tags
$show_tags = isset($meta_values['show_tags']) ? $meta_values['show_tags'] : false;;


//new sort order

$sort_order = get_post_meta($post_id, '_clbgd_sort_order', true);
$sort_order = $sort_order ? strtoupper($sort_order) : 'DESC'; 

// sorting options
$sort_options = array(

    'ASC'        => ['orderby' => 'date', 'order' => 'ASC'],
    'DESC'       => ['orderby' => 'date', 'order' => 'DESC'],
    'A-Z'        => ['orderby' => 'title', 'order' => 'ASC'],
    'Z-A'        => ['orderby' => 'title', 'order' => 'DESC'],
    'MODIFIED'   => ['orderby' => 'modified', 'order' => 'DESC'],
    'RANDOMLY'   => ['orderby' => 'rand'],
    'AUTHOR'     => ['orderby' => 'author', 'order' => 'ASC'],
    'POPULARITY' => ['orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => 'post_views_count'],
    'COMMENT'    => ['orderby' => 'comment_count', 'order' => 'DESC'],

    // 'FEATURED'   => [
    //     'orderby' => ['meta_value_num' => 'DESC', 'date' => 'DESC'],
    //     'meta_key' => 'is_featured'
    // ],

    'CUSTOM'     => ['orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_key' => 'custom_order']
    
);

// fallback
$selected_sort = $sort_options[$sort_order] ?? $sort_options['DESC'];


$args = array_merge([
    'post_type'      => 'post',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
], $selected_sort);


$query = new WP_Query($args);
//end sort order


if ($query->have_posts()) :
    echo '<div class="clbgd-blog-list-wrapper">
    <div class="container">';

    while ($query->have_posts()) : $query->the_post(); ?>

<div class="row clbgd-blog-list-item">
    <?php 
        if ($enable_featured_image !== 'disable' && has_post_thumbnail()) : ?>
    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="clbgd-blog-post-image align-self-center">
            <div class="clbgd-blog-list-img-outer">
                <?php the_post_thumbnail('medium'); ?>
            </div>
        </div>
        
        </div>
        <?php endif; ?>
        <div class="col-lg-6 col-md-6 col-sm-6  ">
            <div class=" clbgd-blog-post-title-outer-box align-self-center">
                <!-- new one add for font check -->
                <h2 class="clbgd-blog-post-title clbgd-blog-post-title2">
                    <a class="clbgd-blog-post-title2" href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>


                <div class="clbgd-blog-category-title">
                    <?php if ($show_categories): ?>
                    <p class="clbgd-blog-post-category clbgd-blog-post-content2 clbgd-blog-post-content2 a">
                        <?php echo esc_html__('Category: ', 'classic-blog-grid') . wp_kses_post(get_the_category_list(', ')); ?>
                    </p>
                    <?php endif; ?>
                </div>

                <div class="clbgd-list-admin-comment-box">
                    <?php if ($show_date): ?>
                    <p class="clbgd-blog-post-date clbgd-blog-post-content2"><?php echo esc_html(get_the_date('F j, Y')); ?></p>
                    <?php endif; ?>

                    <?php if ($show_author): ?>
                    <p class="clbgd-blog-post-author clbgd-blog-post-content2 align-self-center">
                        <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ($show_comments): ?>
                    <p class="clbgd-blog-post-comments align-self-center clbgd-blog-post-content2">
                        <?php echo esc_html(get_comments_number()) . ' ' . esc_html__('Comments', 'classic-blog-grid'); ?>
                    </p>
                    <?php endif; ?>
                </div>


                <div class="clbgd-list-post-content-box">
                    <?php if ($show_excerpt): ?>
                    <div class="clbgd-blog-post-excerpt clbgd-blog-post-excerpt2">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), $excerpt_length)); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- show tags -->
                <?php if ($show_tags): // Check if tags should be displayed ?>
                <?php 
                $tags = get_the_tags(); 
                if ($tags): ?>
                <p class="clbgd-blog-post-tags clbgd-blog-post-content2">
                    <?php foreach ($tags as $tag): ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                        <?php echo esc_html($tag->name); ?>
                    </a>
                    <?php endforeach; ?>
                </p>
                <?php endif; ?>
                <?php endif; ?>
                <!-- end -->

                <!-- show social share -->

                <?php if ($show_social_share): ?>
                <div class="clbgd-social-share-buttons">
                    <span class="clbgd-blog-post-content2"><?php esc_html_e('Share:', 'classic-blog-grid'); ?></span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                        target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                        target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                        target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url()); ?>&description=<?php echo urlencode(get_the_title()); ?>"
                        target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                </div>
                <?php endif; ?>

                <!-- END Social Share Buttons -->

                <div class=" clbgd-list-button-box">
                    <a href="<?php echo esc_url(get_permalink()); ?>"
                        class="clbgd-read-more-btn clbgd-blog-post-content2"><?php esc_html_e('Read More', 'classic-blog-grid'); ?></a>
                </div>
    </div>
</div>
<?php// endif; ?>
<!-- END featured image -->



</div>

<?php endwhile;

    echo '</div>';
else :
    echo '<p>' . esc_html__('No posts found.', 'classic-blog-grid') . '</p>';
endif; ?>

<div class="clbgd-pagination">
    <?php
    if ($query->max_num_pages > 1) {
        echo wp_kses_post(paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'prev_text' => __('« Previous', 'classic-blog-grid'),
            'next_text' => __('Next »', 'classic-blog-grid')
        )));
    }
    ?>
</div>
</div>
<?php
wp_reset_postdata();
?>