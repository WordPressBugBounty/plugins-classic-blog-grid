<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
// Template for Blog Masonry
$clbgd_posts_per_page = get_post_meta($post_id, '_clbgd_posts_per_page', true);
$clbgd_posts_per_page = $clbgd_posts_per_page ? $clbgd_posts_per_page : 9;
$clbgd_show_date = $meta_values['show_date'];
$clbgd_show_author = $meta_values['show_author'];
$clbgd_show_comments = $meta_values['show_comments'];
$clbgd_show_excerpt = $meta_values['show_excerpt'];
$clbgd_show_read_more = $meta_values['show_read_more'];
$clbgd_excerpt_length = $meta_values['excerpt_length'] ?: 15;
$clbgd_title_length = $meta_values['title_length'];
$clbgd_show_categories = $meta_values['show_categories'];
$clbgd_enable_featured_image = $meta_values['enable_featured_image'];
$clbgd_show_social_share = $meta_values['show_social_share'];
//show tags
$clbgd_show_tags = isset($meta_values['show_tags']) ? $meta_values['show_tags'] : false;
;
$clbgd_posts_per_row = get_post_meta($post_id, '_clbgd_posts_per_row', true);
$clbgd_posts_per_row = $clbgd_posts_per_row ? $clbgd_posts_per_row : 2;
$clbgd_enable_ajax_masonry = get_post_meta($post_id, '_clbgd_enable_ajax_masonry', true);
$clbgd_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
//new sort order
$clbgd_sort_order = get_post_meta($post_id, '_clbgd_sort_order', true);
$clbgd_sort_order = $clbgd_sort_order ? strtoupper($clbgd_sort_order) : 'DESC';
// sorting options
// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
$clbgd_sort_options = array(
    'ASC' => ['orderby' => 'date', 'order' => 'ASC'],
    'DESC' => ['orderby' => 'date', 'order' => 'DESC'],
    'A-Z' => ['orderby' => 'title', 'order' => 'ASC'],
    'Z-A' => ['orderby' => 'title', 'order' => 'DESC'],
    'MODIFIED' => ['orderby' => 'modified', 'order' => 'DESC'],
    'RANDOMLY' => ['orderby' => 'rand'],
    'AUTHOR' => ['orderby' => 'author', 'order' => 'ASC'],
    'POPULARITY' => ['orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => 'post_views_count'],
    'COMMENT' => ['orderby' => 'comment_count', 'order' => 'DESC'],
    'CUSTOM' => ['orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_key' => 'custom_order']
);
// phpcs:enable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
// fallback
$clbgd_selected_sort = $clbgd_sort_options[$clbgd_sort_order] ?? $clbgd_sort_options['DESC'];

$clbgd_args = array_merge([
    'post_type' => 'post',
    'posts_per_page' => $clbgd_posts_per_page,
    'paged' => $clbgd_paged,
], $clbgd_selected_sort);

$clbgd_tax_query = [];

$clbgd_include_slugs = array_filter(array_map('trim', explode(',', $meta_values['include_categories_tags'] ?? '')));
$clbgd_exclude_slugs = array_filter(array_map('trim', explode(',', $meta_values['exclude_categories_tags'] ?? '')));

if (!empty($clbgd_include_slugs)) {
    $clbgd_tax_query[] = [
        'taxonomy' => 'category',
        'field' => 'slug',
        'terms' => $clbgd_include_slugs,
        'operator' => 'IN',
    ];
}

if (!empty($clbgd_exclude_slugs)) {
    $clbgd_tax_query[] = [
        'taxonomy' => 'category',
        'field' => 'slug',
        'terms' => $clbgd_exclude_slugs,
        'operator' => 'NOT IN',
    ];
}
// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_tax_query
if (!empty($clbgd_tax_query)) {
    $clbgd_args['tax_query'] = count($clbgd_tax_query) > 1 ? array_merge(['relation' => 'AND'], $clbgd_tax_query) : $clbgd_tax_query;
}
// phpcs:enable WordPress.DB.SlowDBQuery.slow_db_query_tax_query
$clbgd_query = new WP_Query($clbgd_args);
//end sort order

if ($clbgd_query->have_posts()): ?>
    <div class="container">
        <div class="masonry-container">
            <?php while ($clbgd_query->have_posts()):
                $clbgd_query->the_post(); ?>

                <div class="masonry-item" <?php if ($clbgd_enable_featured_image !== 'disable' && has_post_thumbnail()): ?>
                        style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>'); background-size: cover; background-position: center;"
                    <?php endif; ?>>
                    <div class="masonry-item-content-wrapper">
                        <div class="clbgd blog-content-box">
                            <h2 class="clbgd-masonry-item-title clbgd-blog-post-tittle-font">
                                <a class="clbgd-blog-post-tittle-font" href="<?php echo esc_url(get_permalink()); ?>"
                                    title="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php echo $clbgd_title_length ? esc_html(wp_trim_words(get_the_title(), $clbgd_title_length)) : esc_html(get_the_title()); ?>
                                </a>
                            </h2>
                            <div class="clbgd-masonry-meta-items">
                                <?php if ($clbgd_show_date): ?>
                                    <p class="clbgd-masonry-item-date clbgd-blog-post-meta-font">
                                        <?php echo esc_html(get_the_date('F j, Y')); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($clbgd_show_author): ?>
                                    <p class="clbgd-masonry-item-author clbgd-blog-post-meta-font">
                                        <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <?php if ($clbgd_show_categories): ?>
                                <p class="clbgd-masonry-item-category clbgd-blog-post-meta-font">
                                    <?php echo esc_html__('Category: ', 'classic-blog-grid') . wp_kses_post(get_the_category_list(', ')); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($clbgd_show_excerpt): ?>
                                <p class="clbgd-masonry-item-excerpt clbgd-blog-post-excerpt-font">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), $clbgd_excerpt_length, '...')); ?>
                                </p>
                            <?php endif; ?>
                            <!-- show tags -->
                            <?php if ($clbgd_show_tags): ?>
                                <?php
                                $clbgd_tags = get_the_tags();
                                if ($clbgd_tags): ?>
                                    <p class="clbgd-blog-post-tags clbgd-blog-post-meta-font">
                                        <?php foreach ($clbgd_tags as $tag): ?>
                                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                                <?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <!-- end -->
                            <!-- show social share -->
                            <div class="clbgd-blogs-share-comment">
                                <?php if ($clbgd_show_social_share): ?>
                                    <div class="clbgd-social-share-buttons">
                                        <span
                                            class="clbgd-blog-post-meta-font"><?php esc_html_e('Share:', 'classic-blog-grid'); ?></span>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-facebook-f clbgd-blog-post-meta-font"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-twitter clbgd-blog-post-meta-font"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-linkedin-in clbgd-blog-post-meta-font"></i>
                                        </a>
                                        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url()); ?>&description=<?php echo urlencode(get_the_title()); ?>"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-pinterest-p clbgd-blog-post-meta-font"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if ($clbgd_show_comments): ?>
                                    <p class="clbgd-masonry-item-comments clbgd-blog-post-meta-font">
                                        <?php echo esc_html(get_comments_number()) . ' ' . esc_html__('Comments', 'classic-blog-grid'); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <!-- END Social Share Buttons -->
                            <?php if ($clbgd_show_read_more): ?>
                                <a href="<?php echo esc_url(get_permalink()); ?>"
                                    class="clbgd-masonry-item-button clbgd-blog-post-content2 clbgd-button"><?php echo esc_html($meta_values['custom_read_more_text']); ?></a>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="masonry-item-overlay">
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php if ($clbgd_enable_ajax_masonry == 'disable'): ?>
        <?php if (isset($meta_values['show_pagination']) && $meta_values['show_pagination'] === '1'): ?>
            <div class="pagination">
                <?php
                $clbgd_pagination_links = paginate_links(array(
                    'total' => $clbgd_query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'format' => '?paged=%#%',
                    'prev_text' => __('« Previous', 'classic-blog-grid'),
                    'next_text' => __('Next »', 'classic-blog-grid'),
                ));

                if (!empty($clbgd_pagination_links)) {
                    echo wp_kses_post($clbgd_pagination_links);
                }
                ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
    <!-- end -->
    <!-- Load More Button for dynamic loding products  -->
    <?php if ($clbgd_enable_ajax_masonry !== 'disable'): ?>
        <?php if ($clbgd_query->max_num_pages > 1): ?>
            <div id="load-more-container" style="text-align: center; margin: 20px 0;">
                <button id="load-more" data-page="1" data-max-pages="<?php echo esc_attr($clbgd_query->max_num_pages); ?>"
                    data-post-id="<?php echo esc_attr(get_the_ID()); ?>" data-show-date="<?php echo esc_attr($clbgd_show_date); ?>"
                    data-show-author="<?php echo esc_attr($clbgd_show_author); ?>"
                    data-show-categories="<?php echo esc_attr($clbgd_show_categories); ?>"
                    data-show-excerpt="<?php echo esc_attr($clbgd_show_excerpt); ?>" data-show-tags="<?php echo esc_attr($clbgd_show_tags); ?>"
                    data-excerpt-length="<?php echo esc_attr($clbgd_excerpt_length); ?>"
                    data-sort-order="<?php echo esc_attr($clbgd_sort_order); ?>"
                    data-show-comments="<?php echo esc_attr($clbgd_show_comments); ?>" \
                    data-enable-featured-image="<?php echo esc_attr($clbgd_enable_featured_image); ?>"
                    data-posts-per-page="<?php echo esc_attr($clbgd_posts_per_page); ?>"
                    data-show-social-share="<?php echo esc_attr($clbgd_show_social_share); ?>">
                    Load More
                </button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
    <p><?php esc_html_e('No posts found.', 'classic-blog-grid'); ?></p>
<?php endif;
wp_reset_postdata(); ?>