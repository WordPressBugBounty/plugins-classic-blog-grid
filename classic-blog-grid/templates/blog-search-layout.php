<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
$posts_per_page = get_post_meta($post_id, '_clbgd_posts_per_page', true);
$posts_per_page = $posts_per_page ? $posts_per_page : 2;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : ''; // Get search query
//new
$display_search_box = $meta_values['_clbgd_display_search_box'] ?? '';
$show_date = $meta_values['show_date'];
$show_author = $meta_values['show_author'];
$show_comments = $meta_values['show_comments'];
$show_excerpt = $meta_values['show_excerpt'];
$excerpt_length = $meta_values['excerpt_length'] ?: 15;
$show_categories = $meta_values['show_categories'];
$enable_featured_image = $meta_values['enable_featured_image'];
$show_social_share = $meta_values['show_social_share'];
$show_tags = isset($meta_values['show_tags']) ? $meta_values['show_tags'] : false;
$sort_order = get_post_meta($post_id, '_clbgd_sort_order', true);
$sort_order = $sort_order ? strtoupper($sort_order) : 'DESC';

//end
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => $posts_per_page,
    'order'          => 'DESC',
    'orderby'        => 'date',
    'paged'          => $paged,
);

if (!empty($search_query)) {
    $args['s'] = $search_query; // Add search filter
}

$query = new WP_Query($args);
?>
<div class="container">
<!-- Search Form -->
<?php if ($display_search_box === 'enable') : ?>
<form id="clbgd-search-form" 
    data-show-date="<?php echo esc_attr($show_date); ?>" 
    data-sort-order="<?php echo esc_attr($sort_order); ?>" 
    data-show-author="<?php echo esc_attr($show_author); ?>" 
    data-show-comments="<?php echo esc_attr($show_comments); ?>"
    data-show-excerpt="<?php echo esc_attr($show_excerpt); ?>"
    data-excerpt-length="<?php echo esc_attr($excerpt_length); ?>"
    data-show-categories="<?php echo esc_attr($show_categories); ?>"
    data-enable-featured-image="<?php echo esc_attr($enable_featured_image); ?>"
    data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>"
    data-show-tags="<?php echo esc_attr($show_tags); ?>"
    data-show-social-share="<?php echo esc_attr($show_social_share); ?>"
    > <!-- Added this -->
    <input type="text" id="clbgd-search-input" name="s" placeholder="Search...">
    <button type="submit">Search</button>
</form>
<?php endif;?>
<!-- Blog Grid -->
<?php if ($query->have_posts()) : ?>
    <div id="clbgd-search-results" class="clbgd-blog-grid-wrapper">
      <div class="row">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
        <div class="col-lg-6">
            <div class="clbgd-blog-grid-item">
                <?php if ($enable_featured_image !== 'disable' && has_post_thumbnail()) : ?>
                    <div class="clbgd-blog-grid-image">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="clbgd-blog-grid-content">
                    <h2 class="clbgd-blog-grid-title clbgd-blog-post-tittle-font">
                        <a class="clbgd-blog-post-tittle-font" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?></a>
                    </h2>
                    <?php if ($show_excerpt): ?>
                    <div class="clbgd-blog-grid-excerpt clbgd-blog-post-excerpt-font">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?>
                    </div>
                    <?php endif; ?>

                <div class="clbgd-list-admin-comment-box ">
                    <?php if ($show_date): ?>
                        <p class="clbgd-blog-post-date clbgd-blog-post-meta-font"><?php echo esc_html(get_the_date('F j, Y')); ?></p>
                    <?php endif; ?>
    
                    <?php if ($show_author): ?>
                        <p class="clbgd-blog-post-author clbgd-blog-post-meta-font align-self-center">
                            <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?>
                        </p>
                    <?php endif; ?>
    
                    <?php if ($show_comments): ?>
                        <p class="clbgd-blog-post-comments clbgd-blog-post-meta-font align-self-center">
                            <?php echo esc_html(get_comments_number()) . ' ' . esc_html__('Comments', 'classic-blog-grid'); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="clbgd-blog-category-title">
                   <?php if ($show_categories): ?>
                       <p class="clbgd-blog-post-category clbgd-blog-post-meta-font">
                           <?php echo esc_html__('Category: ', 'classic-blog-grid') . wp_kses_post(get_the_category_list(', ')); ?>
                       </p>
                   <?php endif; ?>
               </div>
                 <!-- Show Tags -->
                 <?php if ($show_tags): ?>
                        <?php 
                        $tags = get_the_tags(); 
                        if ($tags): ?>
                            <p class="clbgd-grid-tags clbgd-blog-post-meta-font">
                                <?php foreach ($tags as $tag): ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>

                     <!-- show social share -->
             
	             	    <?php if ($show_social_share): ?>
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
                </div>
            </div>
            </div>
        <?php endwhile; ?>
    </div>
    </div>
    </div>
    <!-- Pagination -->
    <?php if ($query->max_num_pages > 1) : ?>
        <div class="clbgd-pagination">
            <?php
            echo wp_kses_post(paginate_links(array(
                'base'      => str_replace(99999, '%#%', esc_url(get_pagenum_link(99999))),
                'format'    => '?paged=%#%',
                'total'     => $query->max_num_pages,
                'current'   => max(1, $paged),
                'prev_text' => __('« Previous', 'classic-blog-grid'),
                'next_text' => __('Next »', 'classic-blog-grid'),
                'add_args'  => array('s' => $search_query),
            )));
            ?>
        </div>
    <?php endif; ?>
<?php else : ?>
    <p class="clbgd-no-posts"><?php esc_html_e('No posts found.', 'classic-blog-grid'); ?></p>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

