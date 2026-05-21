<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

$clbgd_posts_per_page = get_post_meta($post_id, '_clbgd_posts_per_page', true);
$clbgd_posts_per_page = $clbgd_posts_per_page ? $clbgd_posts_per_page : 5;
$clbgd_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
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
$clbgd_show_tags = isset($meta_values['show_tags']) ? $meta_values['show_tags'] : false;
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
if ($clbgd_query->have_posts()):
    echo '<div class="clbgd-grid-wrapper">
    <div class="container">
    <div class="row">';
    while ($clbgd_query->have_posts()):
        $clbgd_query->the_post(); ?>
        <div class="col-lg-4 col-md-6">
            <div class="clbgd-grid-item">
                <div class="clbgd-grid-item-inner">
                    <?php if ($clbgd_enable_featured_image !== 'disable' && has_post_thumbnail()): ?>
                        <?php
                        $clbgd_image_aspect_class = '';
                        if (!empty($meta_values['image_aspect_ratio'])) {
                            $clbgd_image_aspect_class = 'aspect-' . esc_attr($meta_values['image_aspect_ratio']); // e.g., 16-9, 1-1
                        }
                        ?>
                        <div class="clbgd-grid-image <?php echo esc_attr($clbgd_image_aspect_class); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="clbgd-grid-content">
                        <h2 class="clbgd-grid-title clbgd-blog-post-tittle-font">
                            <a class="clbgd-blog-post-content2" href="<?php echo esc_url(get_permalink()); ?>"
                                title="<?php echo esc_attr(get_the_title()); ?>">
                        <?php echo $clbgd_title_length ? esc_html(wp_trim_words(get_the_title(), $clbgd_title_length)) : esc_html(get_the_title()); ?>
                            </a>
                        </h2>
                        <?php if ($clbgd_show_excerpt): ?>
                        <div class="clbgd-grid-excerpt clbgd-blog-post-excerpt-font">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), $clbgd_excerpt_length)); ?>
                        </div>
                        <?php endif; ?>

                        <div class="clbgd-grid-admin-info">
                            <?php if ($clbgd_show_date): ?>
                                <p class="clbgd-grid-date clbgd-blog-post-meta-font"><?php echo esc_html(get_the_date('F j, Y')); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($clbgd_show_author): ?>
                                <p class="clbgd-grid-author clbgd-blog-post-meta-font">
                                    <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?></p>
                            <?php endif; ?>

                            <?php if ($clbgd_show_comments): ?>
                                <p class="clbgd-grid-comments clbgd-blog-post-meta-font">
                                    <?php echo esc_html(get_comments_number()) . ' ' . esc_html__('Comments', 'classic-blog-grid'); ?>
                                </p>
                            <?php endif; ?>

                        </div>
                        <div class="clbgd-blog-category-title">
                            <?php if ($clbgd_show_categories): ?>
                                <p class="clbgd-blog-post-category clbgd-blog-post-meta-font">
                                    <?php echo esc_html__('Category: ', 'classic-blog-grid') . wp_kses_post(get_the_category_list(', ')); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <!-- Show Tags -->
                        <?php if ($clbgd_show_tags): ?>
                            <?php
                            $clbgd_tags = get_the_tags();
                            if ($clbgd_tags): ?>
                                <p class="clbgd-grid-tags clbgd-blog-post-meta-font">
                                    <?php foreach ($clbgd_tags as $tag): ?>
                                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- show social share -->
                        <?php if ($clbgd_show_social_share): ?>
                            <div class="clbgd-social-share-buttons">
                                <span class="clbgd-blog-post-meta-font"><?php esc_html_e('Share:', 'classic-blog-grid'); ?></span>
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
                    </div>
                    <?php if ($clbgd_show_read_more): ?>
                        <div class="clbgd-grid-read-more">
                            <a href="<?php echo esc_url(get_permalink()); ?>"
                                class="clbgd-read-more-btn clbgd-blog-post-content2 clbgd-button"><?php echo esc_html($meta_values['custom_read_more_text']); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endwhile;

    echo '</div>';
else:
    echo '<p>' . esc_html__('No posts found.', 'classic-blog-grid') . '</p>';
endif; ?>

<!-- Pagination -->
<?php if (isset($meta_values['show_pagination']) && $meta_values['show_pagination'] === '1'): ?>
    <div class="clbgd-pagination">
        <?php
        if ($clbgd_query->max_num_pages > 1) {
            echo wp_kses_post(paginate_links(array(
                'total' => $clbgd_query->max_num_pages,
                'current' => $clbgd_paged,
                'prev_text' => __('« Previous', 'classic-blog-grid'),
                'next_text' => __('Next »', 'classic-blog-grid')
            )));
        }
        ?>
    </div>
    </div>
    </div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>