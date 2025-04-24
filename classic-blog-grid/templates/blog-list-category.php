<?php
if (!defined('ABSPATH')) {
    exit;
}

// Fetch categories
$categories = get_categories(array(
    'orderby' => 'name',
    'order'   => 'ASC'
));

// Fetch posts based on selected category
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';

$posts_per_page = get_post_meta($post_id, '_clbgd_posts_per_page', true);
$posts_per_page = $posts_per_page ? $posts_per_page : 5;

//new add
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
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$enable_sidebar_category_filter = $meta_values['_clbgd_enable_sidebar_category_filter'];
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


//$query = new WP_Query($args);
//end sort order

if ($selected_category) {
    $args['cat'] = $selected_category;
    // $args['cat'] = (int) $selected_category;
}

$query = new WP_Query($args);

if ($query->have_posts()) :
?>
<div class="container">

    <div class="clbgd-blog-list-layout">
        <!-- Sidebar with Categories -->
        <?php if ($enable_sidebar_category_filter === 'enable') : ?>
        <aside class="clbgd-category-sidebar">
            

            <ul>
                <li>
                    <a href="<?php echo esc_url(remove_query_arg('category', get_permalink())); ?>"
                       class="<?php echo empty($selected_category) ? 'active' : ''; ?>">All</a>
                </li>
            
                <?php foreach ($categories as $category) : ?>
                    <li>
                        <a href="<?php echo esc_url(add_query_arg('category', $category->term_id, get_permalink())); ?>"
                           class="<?php echo ($category->term_id == $selected_category) ? 'active' : ''; ?>">
                            <?php echo esc_html($category->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </aside>
        <?php endif?>

        <!-- Posts List -->
        <main class="clbgd-posts-list">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="row clbgd-post-item">
                <?php  if ($enable_featured_image !== 'disable' && has_post_thumbnail()) : ?>
                <div class="col-lg-6">
                    <div class="clbgd-post-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>

                </div>
                <?php endif; ?>
                <div class="col-lg-6 ">
                    <div class="clbgd-post-details">
                        <h3 class="clbgd-blog-post-title2"><a class="clbgd-blog-post-title2" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="clbgd-post-meta-box">
                        <?php if ($show_date): ?>
                        <p class="clbgd-timeline-date clbgd-blog-post-content2"><?php echo esc_html(get_the_date('F j, Y')); ?></p>
                        <?php endif; ?>

                        <?php if ($show_author): ?>
                        <p class="clbgd-timeline-author clbgd-blog-post-content2">
                            <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?></p>
                        <?php endif; ?>

                        <?php if ($show_comments): ?>
                        <p class="clbgd-timeline-comments clbgd-blog-post-content2">
                            <?php echo esc_html(get_comments_number()) . ' ' . esc_html__('Comments', 'classic-blog-grid'); ?>
                        </p>
                        <?php endif; ?>
                        </div>


                        <?php if ($show_categories): ?>
                        <p class="clbgd-blog-post-category clbgd-blog-post-content2">
                            <?php echo esc_html__('Category: ', 'classic-blog-grid') . wp_kses_post(get_the_category_list(', ')); ?>
                        </p>
                        <?php endif; ?>

                        <?php if ($show_excerpt): ?>
                        <div class="clbgd-blog-post-excerpt clbgd-blog-post-excerpt2">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), $excerpt_length)); ?>
                        </div>
                        <?php endif; ?>


                        <!-- for show tags  -->
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

                        <!-- end show tag -->

                        <!-- show social share -->

                        <?php if ($show_social_share): ?>
                        <div class="clbgd-social-share-buttons">
                            <span class="clbgd-blog-post-content2"><?php esc_html_e('Share:', 'classic-blog-grid'); ?></span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook-f clbgd-blog-post-content2 "></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-twitter clbgd-blog-post-content2"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-linkedin-in clbgd-blog-post-content2"></i>
                            </a>
                            <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url()); ?>&description=<?php echo urlencode(get_the_title()); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-pinterest-p clbgd-blog-post-content2"></i>
                            </a>
                        </div>
                        <?php endif; ?>

                        <!-- END Social Share Buttons -->


                    </div>
                    </div>
                </div>
                <?php endwhile; ?>
        </main>
    </div>

    <!-- Pagination -->
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
else :
    echo '<p>No posts found.</p>';
endif;

wp_reset_postdata();
?>