<?php
function clbgd_ajax_search() {

$search_query = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
$posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 2; 
// Get values
$show_date = isset($_POST['show_date']) ? filter_var($_POST['show_date'], FILTER_VALIDATE_BOOLEAN) : false;
$show_author = isset($_POST['show_author']) ? filter_var($_POST['show_author'], FILTER_VALIDATE_BOOLEAN) : false;
$show_comments = isset($_POST['show_comments']) ? filter_var($_POST['show_comments'], FILTER_VALIDATE_BOOLEAN) : false;
$show_excerpt = isset($_POST['show_excerpt']) ? filter_var($_POST['show_excerpt'], FILTER_VALIDATE_BOOLEAN) : false;
$excerpt_length = isset($_POST['excerpt_length']) ? intval($_POST['excerpt_length']) : 15;
$show_categories = isset($_POST['show_categories']) ? filter_var($_POST['show_categories'], FILTER_VALIDATE_BOOLEAN) : false;
$enable_featured_image = isset($_POST['enable_featured_image']) ? sanitize_text_field($_POST['enable_featured_image']) : 'enable';
$show_tags = isset($_POST['show_tags']) ? filter_var($_POST['show_tags'], FILTER_VALIDATE_BOOLEAN) : false;
$show_social_share = isset($_POST['show_social_share']) ? filter_var($_POST['show_social_share'], FILTER_VALIDATE_BOOLEAN) : false;
$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
$sort_order = isset($_POST['sort_order']) ? sanitize_text_field($_POST['sort_order']) : 'DESC';
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
    'CUSTOM'     => ['orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_key' => 'custom_order']
);

// fallback
$selected_sort = $sort_options[$sort_order] ?? $sort_options['DESC'];
$args = array_merge([
    'post_type'      => 'post',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
], $selected_sort);

 if (!empty($search_query)) {
     $args['s'] = $search_query;
 }
 $query = new WP_Query($args);

 if ($query->have_posts()) {
     ob_start();

     ?>
     <div class="row">
     <?php
     while ($query->have_posts()) : $query->the_post(); ?>
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
                     <a clas="clbgd-blog-post-tittle-font clbgd-blog-post-tittle-font" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                 </h2>

                 <div class="clbgd-search-post-content-box">
                 <?php if ($show_excerpt): ?>
                     <div class="clbgd-blog-post-excerpt clbgd-blog-post-excerpt-font">
                         <?php echo esc_html(wp_trim_words(get_the_excerpt(), $excerpt_length)); ?>
                     </div>
                 <?php endif; ?>
             </div>

                 <div class="clbgd-list-admin-comment-box">
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
             <!-- show tags -->
         <?php if ($show_tags):?>
             <?php 
             $tags = get_the_tags(); 
             if ($tags): ?>
                 <p class="clbgd-blog-post-tags clbgd-blog-post-meta-font">
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
     if ($query->max_num_pages > 1) :
     $pagination = paginate_links(array(
         'total'     => $query->max_num_pages,
         'current'   => $paged,
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