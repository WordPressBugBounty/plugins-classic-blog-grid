<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<?php
function clbgd_ajax_search() {

// phpcs:disable WordPress.Security.NonceVerification.Missing
// phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash

$clbgd_search_query = isset($_POST['search'])
    ? sanitize_text_field( wp_unslash($_POST['search']) )
    : '';

$clbgd_posts_per_page = isset($_POST['posts_per_page'])
    ? intval( wp_unslash($_POST['posts_per_page']) )
    : 2;

// Get values
$clbgd_show_date = isset($_POST['show_date'])
    ? filter_var( wp_unslash($_POST['show_date']), FILTER_VALIDATE_BOOLEAN )
    : false;

$clbgd_show_author = isset($_POST['show_author'])
    ? filter_var( wp_unslash($_POST['show_author']), FILTER_VALIDATE_BOOLEAN )
    : false;

$clbgd_show_comments = isset($_POST['show_comments'])
    ? filter_var( wp_unslash($_POST['show_comments']), FILTER_VALIDATE_BOOLEAN )
    : false;

$clbgd_show_excerpt = isset($_POST['show_excerpt'])
    ? filter_var( wp_unslash($_POST['show_excerpt']), FILTER_VALIDATE_BOOLEAN )
    : false;

$clbgd_show_read_more = isset($_POST['show_read_more'])
    ? filter_var( wp_unslash($_POST['show_read_more']), FILTER_VALIDATE_BOOLEAN )
    : false;

$clbgd_excerpt_length = isset($_POST['excerpt_length'])
    ? intval( wp_unslash($_POST['excerpt_length']) )
    : 15;

$clbgd_show_categories = isset($_POST['show_categories'])
    ? filter_var( wp_unslash($_POST['show_categories']), FILTER_VALIDATE_BOOLEAN )
    : false;

$clbgd_enable_featured_image = isset($_POST['enable_featured_image'])
    ? sanitize_text_field( wp_unslash($_POST['enable_featured_image']) )
    : 'enable';

$clbgd_show_tags = isset($_POST['show_tags'])
    ? filter_var( wp_unslash($_POST['show_tags']), FILTER_VALIDATE_BOOLEAN )
    : false;

$clbgd_show_social_share = isset($_POST['show_social_share'])
    ? filter_var( wp_unslash($_POST['show_social_share']), FILTER_VALIDATE_BOOLEAN )
    : false;

$clbgd_paged = isset($_POST['paged'])
    ? intval( wp_unslash($_POST['paged']) )
    : 1;

$clbgd_sort_order = isset($_POST['sort_order'])
    ? sanitize_text_field( wp_unslash($_POST['sort_order']) )
    : 'DESC';
// phpcs:enable WordPress.Security.NonceVerification.Missing
// phpcs:enable WordPress.Security.ValidatedSanitizedInput.MissingUnslash


// sorting options
// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
$clbgd_sort_options = array(
    'ASC'        => ['orderby' => 'date', 'order' => 'ASC'],
    'DESC'       => ['orderby' => 'date', 'order' => 'DESC'],
    'A-Z'        => ['orderby' => 'title', 'order' => 'ASC'],
    'Z-A'        => ['orderby' => 'title', 'order' => 'DESC'],
    'MODIFIED'   => ['orderby' => 'modified', 'order' => 'DESC'],
    'RANDOMLY'   => ['orderby' => 'rand'],
    'AUTHOR'     => ['orderby' => 'author', 'order' => 'ASC'],
    'POPULARITY' => ['orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => 'post_views_count'],
    'COMMENT'    => ['orderby' => 'comment_count', 'order' => 'DESC'],
    'CUSTOM'     => ['orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_key' => 'custom_order']
);
// phpcs:enable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
// fallback
$clbgd_selected_sort = $clbgd_sort_options[$clbgd_sort_order] ?? $clbgd_sort_options['DESC'];
$clbgd_args = array_merge([
    'post_type'      => 'post',
    'posts_per_page' => $clbgd_posts_per_page,
    'paged'          => $clbgd_paged,
], $clbgd_selected_sort);

 if (!empty($clbgd_search_query)) {
     $clbgd_args['s'] = $clbgd_search_query;
 }
 $clbgd_query = new WP_Query($clbgd_args);

 if ($clbgd_query->have_posts()) {
     ob_start();

     ?>
     <div class="row">
     <?php
     while ($clbgd_query->have_posts()) : $clbgd_query->the_post(); ?>
       <div class="col-lg-6">
         <div class="clbgd-blog-grid-item">
    
             <?php if ($clbgd_enable_featured_image !== 'disable' && has_post_thumbnail()) : ?>
                 <div class="clbgd-blog-grid-image">
                     <a href="<?php the_permalink(); ?>">
                         <?php the_post_thumbnail('medium'); ?>
                     </a>
                 </div>
             <?php endif; ?>

             <div class="clbgd-blog-grid-content">
                 <h2 class="clbgd-blog-grid-title clbgd-blog-post-tittle-font">
                     <a clas="clbgd-blog-post-tittle-font clbgd-blog-post-tittle-font" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                 </h2>

                 <div class="clbgd-search-post-content-box">
                 <?php if ($clbgd_show_excerpt): ?>
                     <div class="clbgd-blog-post-excerpt clbgd-blog-post-excerpt-font">
                         <?php echo esc_html(wp_trim_words(get_the_excerpt(), $clbgd_excerpt_length)); ?>
                     </div>
                 <?php endif; ?>
             </div>

                 <div class="clbgd-list-admin-comment-box">
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
             <!-- show tags -->
         <?php if ($clbgd_show_tags):?>
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
             </div>
         </div>
         </div>
        <?php endwhile; ?>
    </div>
    <?php
     $html = ob_get_clean();
     if ($clbgd_query->max_num_pages > 1) :
     $pagination = paginate_links(array(
         'total'     => $clbgd_query->max_num_pages,
         'current'   => $clbgd_paged,
         'prev_text' => __('« Previous', 'classic-blog-grid'),
         'next_text' => __('Next »', 'classic-blog-grid'),
         'format'    => '?paged=%#%',
         'add_args'  => false, // Important: avoid appending unnecessary query args
     ));
    endif;
     wp_send_json_success(['html' => $html, 'pagination' => $pagination]);
 } else {
     wp_send_json_error(['message' => 'No posts found.' , 'pagination' => '']);
 }
 wp_die();
}
add_action('wp_ajax_clbgd_search', 'clbgd_ajax_search');
add_action('wp_ajax_nopriv_clbgd_search', 'clbgd_ajax_search');