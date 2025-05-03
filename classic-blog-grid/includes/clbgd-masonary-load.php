<?php
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
function load_more_posts() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $show_date = isset($_POST['show_date']) ? filter_var($_POST['show_date'], FILTER_VALIDATE_BOOLEAN) : false;
    $show_author = isset($_POST['show_author']) ? filter_var($_POST['show_author'], FILTER_VALIDATE_BOOLEAN) : false;
    $show_categories = isset($_POST['show_categories']) ? filter_var($_POST['show_categories'], FILTER_VALIDATE_BOOLEAN) : false;
    $show_excerpt = isset($_POST['show_excerpt']) ? filter_var($_POST['show_excerpt'], FILTER_VALIDATE_BOOLEAN) : false;
    $show_tags = isset($_POST['show_tags']) ? filter_var($_POST['show_tags'], FILTER_VALIDATE_BOOLEAN) : false;
    $excerpt_length = isset($_POST['excerpt_length']) ? intval($_POST['excerpt_length']) : 15;
    $show_comments = isset($_POST['show_comments']) ? filter_var($_POST['show_comments'], FILTER_VALIDATE_BOOLEAN) : false;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 2; 
    // Get values
    $show_categories = isset($_POST['show_categories']) ? filter_var($_POST['show_categories'], FILTER_VALIDATE_BOOLEAN) : false;
    $enable_featured_image = isset($_POST['enable_featured_image']) ? sanitize_text_field($_POST['enable_featured_image']) : 'enable';
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
       'paged'          => $page,
   ], $selected_sort);

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        ob_start();

        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="masonry-item" <?php if ($enable_featured_image !== 'disable' && has_post_thumbnail()) : ?>
            style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>'); background-size: cover; background-position: center;"
            <?php endif; ?>>
                <div class="masonry-item-content-wrapper">
                    <div class="clbgd blog-content-box">

                        <h2 class="clbgd-masonry-item-title clbgd-blog-post-tittle-font">
                        <a class="clbgd-blog-post-tittle-font" href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                        <?php the_title(); ?>
                        </a>
                        </h2>
                        <div class="clbgd-masonry-meta-items">
                            <?php if ($show_date): ?>
                                <p class="clbgd-masonry-item-date clbgd-blog-post-meta-font">
                                    <?php echo esc_html(get_the_date('F j, Y')); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($show_author): ?>
                                <p class="clbgd-masonry-item-author clbgd-blog-post-meta-font">
                                    <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($show_categories): ?>
                                <p class="clbgd-masonry-item-category clbgd-blog-post-meta-font">
                                    <?php echo esc_html__('Category: ', 'classic-blog-grid') . wp_kses_post(get_the_category_list(', ')); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php if ($show_excerpt): ?>
                            <p class="clbgd-masonry-item-excerpt clbgd-blog-post-excerpt-font">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), $excerpt_length, '...')); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($show_tags): ?>
                            <?php $tags = get_the_tags(); ?>
                            <?php if ($tags): ?>
                                <p class="clbgd-blog-post-tags clbgd-blog-post-meta-font">
                                    <?php foreach ($tags as $tag): ?>
                                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="clbgd-blogs-share-comment">
                      <?php if ($show_social_share): ?>
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
                      <?php if ($show_comments): ?>
                      <p class="clbgd-masonry-item-comments clbgd-blog-post-meta-font">
                          <?php echo esc_html(get_comments_number()) . ' ' . esc_html__('Comments', 'classic-blog-grid'); ?>
                      </p>
                      <?php endif; ?>
                    </div>

                        <a href="<?php echo esc_url(get_permalink()); ?>"
                            class="clbgd-masonry-item-button clbgd-blog-post-content2">Read More</a>
                    </div>     
                </div>
                <div class="masonry-item-overlay"></div>
            </div>
            <?php
        }
        $output = ob_get_clean();
        wp_send_json_success($output);
    } else {
        wp_send_json_error('No posts found.');
    }
    wp_die();
}