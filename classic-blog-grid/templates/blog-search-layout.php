<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
$clbgd_posts_per_page = get_post_meta($post_id, '_clbgd_posts_per_page', true);
$clbgd_posts_per_page = $clbgd_posts_per_page ? $clbgd_posts_per_page : 2;
$clbgd_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading public GET parameter for filtering
$clbgd_search_query = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : ''; // Get search query
//new
$clbgd_display_search_box = $meta_values['_clbgd_display_search_box'] ?? '';
$clbgd_show_date = $meta_values['show_date'];
$clbgd_show_author = $meta_values['show_author'];
$clbgd_show_comments = $meta_values['show_comments'];
$clbgd_show_excerpt = $meta_values['show_excerpt'];
$clbgd_show_read_more = $meta_values['show_read_more'];
$clbgd_excerpt_length = $meta_values['excerpt_length'] ?: 15;
$clbgd_title_length = $meta_values['title_length'];
$clbgd_custom_read_more_text = $meta_values['custom_read_more_text'];
$clbgd_show_categories = $meta_values['show_categories'];
$clbgd_enable_featured_image = $meta_values['enable_featured_image'];
$clbgd_show_social_share = $meta_values['show_social_share'];
$clbgd_show_tags = isset($meta_values['show_tags']) ? $meta_values['show_tags'] : false;
$clbgd_sort_order = get_post_meta($post_id, '_clbgd_sort_order', true);
$clbgd_sort_order = $clbgd_sort_order ? strtoupper($clbgd_sort_order) : 'DESC';

//end
$clbgd_args = array(
    'post_type'      => 'post',
    'posts_per_page' => $clbgd_posts_per_page,
    'order'          => 'DESC',
    'orderby'        => 'date',
    'paged'          => $clbgd_paged,
);

if (!empty($clbgd_search_query)) {
    $clbgd_args['s'] = $clbgd_search_query; // Add search filter
}

$clbgd_tax_query = [];

$clbgd_include_slugs = array_filter(array_map('trim', explode(',', $meta_values['include_categories_tags'] ?? '')));
$clbgd_exclude_slugs = array_filter(array_map('trim', explode(',', $meta_values['exclude_categories_tags'] ?? '')));

if (!empty($clbgd_include_slugs)) {
    $clbgd_tax_query[] = [
        'taxonomy' => 'category',
        'field'    => 'slug',
        'terms'    => $clbgd_include_slugs,
        'operator' => 'IN',
    ];
}

if (!empty($clbgd_exclude_slugs)) {
    $clbgd_tax_query[] = [
        'taxonomy' => 'category',
        'field'    => 'slug',
        'terms'    => $clbgd_exclude_slugs,
        'operator' => 'NOT IN',
    ];
}
// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_tax_query
if (!empty($clbgd_tax_query)) {
    $clbgd_args['tax_query'] = count($clbgd_tax_query) > 1 ? array_merge(['relation' => 'AND'], $clbgd_tax_query) : $clbgd_tax_query;
}
// phpcs:enable WordPress.DB.SlowDBQuery.slow_db_query_tax_query
$clbgd_query = new WP_Query($clbgd_args);
?>
<div class="container">
<!-- Search Form -->
<?php if ($clbgd_display_search_box === 'enable') : ?>
<form id="clbgd-search-form" 
    data-show-date="<?php echo esc_attr($clbgd_show_date); ?>" 
    data-sort-order="<?php echo esc_attr($clbgd_sort_order); ?>" 
    data-show-author="<?php echo esc_attr($clbgd_show_author); ?>" 
    data-show-comments="<?php echo esc_attr($clbgd_show_comments); ?>"
    data-show-excerpt="<?php echo esc_attr($clbgd_show_excerpt); ?>"
    data-excerpt-length="<?php echo esc_attr($clbgd_excerpt_length); ?>"
    data-show-categories="<?php echo esc_attr($clbgd_show_categories); ?>"
    data-enable-featured-image="<?php echo esc_attr($clbgd_enable_featured_image); ?>"
    data-posts-per-page="<?php echo esc_attr($clbgd_posts_per_page); ?>"
    data-show-tags="<?php echo esc_attr($clbgd_show_tags); ?>"
    data-show-social-share="<?php echo esc_attr($clbgd_show_social_share); ?>"
    > <!-- Added this -->
    <input type="text" id="clbgd-search-input" name="s" placeholder="Search...">
    <button type="submit">Search</button>
</form>
<?php endif;?>
<!-- Blog Grid -->
<?php if ($clbgd_query->have_posts()) : ?>
    <div id="clbgd-search-results" class="clbgd-blog-grid-wrapper">
      <div class="row">
        <?php while ($clbgd_query->have_posts()) : $clbgd_query->the_post(); ?>
        <div class="col-lg-6">
            <div class="clbgd-blog-grid-item">
                <?php if ($clbgd_enable_featured_image !== 'disable' && has_post_thumbnail()) : ?>
                    <?php
                    $clbgd_image_aspect_class = '';
                    if (!empty($meta_values['image_aspect_ratio'])) {
                        $clbgd_image_aspect_class = 'aspect-' . esc_attr($meta_values['image_aspect_ratio']); // e.g., 16-9, 1-1
                    }
                    ?>
                    <div class="clbgd-blog-grid-image <?php echo esc_attr($clbgd_image_aspect_class); ?>">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="clbgd-blog-grid-content">
                    <h2 class="clbgd-blog-grid-title clbgd-blog-post-tittle-font">
                        <a class="clbgd-blog-post-tittle-font" href="<?php the_permalink(); ?>">
                        <?php echo $clbgd_title_length ? esc_html(wp_trim_words(get_the_title(), $clbgd_title_length)) : esc_html(get_the_title()); ?></a>
                    </h2>
                    <?php if ($clbgd_show_excerpt): ?>
                    <div class="clbgd-blog-grid-excerpt clbgd-blog-post-excerpt-font">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?>
                    </div>
                    <?php endif; ?>

                <div class="clbgd-list-admin-comment-box ">
                    <?php if ($clbgd_show_date): ?>
                        <p class="clbgd-blog-post-date clbgd-blog-post-meta-font"><?php echo esc_html(get_the_date('F j, Y')); ?></p>
                    <?php endif; ?>
    
                    <?php if ($clbgd_show_author): ?>
                        <p class="clbgd-blog-post-author clbgd-blog-post-meta-font align-self-center">
                            <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?>
                        </p>
                    <?php endif; ?>
    
                    <?php if ($clbgd_show_comments): ?>
                        <p class="clbgd-blog-post-comments clbgd-blog-post-meta-font align-self-center">
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
	             			  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer">
	             				  <i class="fab fa-facebook-f"></i>
	             			  </a>
	             			  <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer">
	             				  <i class="fab fa-twitter"></i>
	             			  </a>
	             			  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer">
	             				  <i class="fab fa-linkedin-in"></i>
	             			  </a>
	             			  <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url()); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer">
	             				  <i class="fab fa-pinterest-p"></i>
	             			  </a>
	             		  </div>
	             	  <?php endif; ?>
		             <!-- END Social Share Buttons -->
                        <?php if ($clbgd_show_read_more): ?>
                        <div class="clbgd-button-box">
                            <a href="<?php echo esc_url(get_permalink()); ?>"
                                class="clbgd-read-more-btn clbgd-blog-post-content2 clbgd-button"><?php echo esc_html($clbgd_custom_read_more_text); ?></a>
                        </div>
                        <?php endif; ?>
                </div>
            </div>
            </div>
        <?php endwhile; ?>
    </div>
    </div>
    </div>
    <!-- Pagination -->
    <?php if (isset($meta_values['show_pagination']) && $meta_values['show_pagination'] === '1') : ?>
        <?php if ($clbgd_query->max_num_pages > 1) : ?>
            <div class="clbgd-pagination">
                <?php
                echo wp_kses_post(paginate_links(array(
                    'base'      => str_replace(99999, '%#%', esc_url(get_pagenum_link(99999))),
                    'format'    => '?paged=%#%',
                    'total'     => $clbgd_query->max_num_pages,
                    'current'   => max(1, $clbgd_paged),
                    'prev_text' => __('« Previous', 'classic-blog-grid'),
                    'next_text' => __('Next »', 'classic-blog-grid'),
                    'add_args'  => array('s' => $clbgd_search_query),
                )));
                ?>
            </div>
        <?php endif; ?>
<?php endif; ?>

<?php else : ?>
    <p class="clbgd-no-posts"><?php esc_html_e('No posts found.', 'classic-blog-grid'); ?></p>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

