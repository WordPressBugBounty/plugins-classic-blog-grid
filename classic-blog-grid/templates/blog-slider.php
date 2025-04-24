<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Template for Blog Slider



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


if ($query->have_posts()) : ?>
<div id="clbgdSlider" class="swiper">

    <div class="swiper-wrapper">
        <?php while ($query->have_posts()) : $query->the_post(); ?>

        <?php $slide_image = ($enable_featured_image === 'enable' && has_post_thumbnail()) ? esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')) : ''; ?>

        <div class="swiper-slide" data-bg="<?php echo esc_url($slide_image); ?>">

            <div class="clbgd-slide-content">

                <!-- Thumbnail Image -->

                <!-- Slide Content -->
                <h2 class="clbgd-slide-title clbgd-blog-post-title2"><?php the_title(); ?></h2>
                <div class="clbgd-meta-slide">
                    <?php if ($show_date): ?>
                    <p class="clbgd-slide-date clbgd-blog-post-content2"><?php echo esc_html(get_the_date('F j, Y')); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ($show_author): ?>
                    <p class="clbgd-slide-author clbgd-blog-post-content2">
                        <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?></p>
                    <?php endif; ?>

                    <?php if ($show_categories): ?>
                    <p class="clbgd-slide-category clbgd-blog-post-content2">
                        <?php echo esc_html__('Category: ', 'classic-blog-grid') . wp_kses_post(get_the_category_list(', ')); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ($show_comments): ?>
                    <p class="clbgd-slide-comments clbgd-blog-post-content2">
                        <?php echo esc_html(get_comments_number()) . ' ' . esc_html__('Comments', 'classic-blog-grid'); ?>
                    </p>
                    <?php endif; ?>
                </div>


                <?php if ($show_excerpt): ?>
                <p class="clbgd-slide-description clbgd-blog-post-excerpt2">
                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), $excerpt_length, '...')); ?></p>
                <?php endif; ?>

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
                        <i class="fab fa-facebook-f clbgd-blog-post-content2"></i>
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

                <a href="<?php the_permalink(); ?>" class="clbgd-slide-button clbgd-blog-post-content2">Learn More</a>
            

            </div>
            <div class="slider-item-overlay">

</div>
        </div>
        <?php endwhile; ?>
    </div>
    <div class="swiper-slider-buttons">
        <!-- Navigation Buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>

    <!-- Pagination -->
    <div class="swiper-pagination"></div>
</div>
<?php else : ?>
<p>No posts found.</p>
<?php 
endif;
wp_reset_postdata();
?>