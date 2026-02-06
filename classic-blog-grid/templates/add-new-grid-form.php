<?php
 if (!defined('ABSPATH')) {
     exit;
 }
$post_id = isset($post_id) ? $post_id : 0; 
$grid_title = isset($grid_title) ? $grid_title : '';
$grid_layout = isset($grid_layout) ? $grid_layout : 'list';
$sort_order = isset($sort_order) ? $sort_order : 'DESC';
$show_date = isset($show_date) ? $show_date : true;
$show_author = isset($show_author) ? $show_author : true;
$show_excerpt = isset($show_excerpt) ? $show_excerpt : true;
$show_read_more = isset($show_read_more) ? $show_read_more : true;
$global_font_color = get_post_meta($post_id, '_clbgd_global_font_color', true) ?: '#ffffff';
$global_button_bg_color = get_post_meta($post_id, '_clbgd_global_button_bg_color', true) ?: '#3db6ff';
$global_button_hover_bg_color = get_post_meta($post_id, '_clbgd_global_button_hover_bg_color', true) ?: '#555753';
//end
$show_categories = isset($show_categories) ? $show_categories : false; 
$show_comments = isset($show_comments) ? $show_comments : false; 
$posts_per_row = isset($posts_per_row) ? $posts_per_row : 3; 
$display_search_box = isset($display_search_box) ? $display_search_box : false; 
$enable_sidebar_category_filter = isset($enable_sidebar_category_filter) ? $enable_sidebar_category_filter : false; 
$enable_featured_posts = isset($enable_featured_posts) ? $enable_featured_posts : false;
$enable_featured_image = isset($enable_featured_image) ? $enable_featured_image : 'enable';
$enable_ajax_masonry = isset($enable_ajax_masonry) ? $enable_ajax_masonry : 'disable';
$slider_animation = isset(  $slider_animation) ?   $slider_animation : false;
$grid_overlay = isset($grid_overlay) ?  $grid_overlay : false;
$blog_title_font = get_post_meta($post_id, '_clbgd_blog_title_font', true) ?: 'Arial';
$blog_title_font_size = get_post_meta($post_id, '_clbgd_blog_title_font_size', true) ?: '';
$blog_excerpt_font = get_post_meta($post_id, '_clbgd_blog_excerpt_font', true) ?: 'Arial';
$blog_excerpt_font_size = get_post_meta($post_id, '_clbgd_blog_excerpt_font_size', true) ?: '';
$custom_css = get_post_meta($post_id , '_clbgd_custom_css' , true) ? : '';
$display_search_box = get_post_meta($post_id, '_clbgd_display_search_box', true);
$enable_sidebar_category_filter = get_post_meta($post_id, '_clbgd_enable_sidebar_category_filter', true);
$show_tags = get_post_meta($post_id, '_clbgd_show_tags', true);
$show_social_share = get_post_meta($post_id, '_clbgd_show_social_share', true);
$is_premium_user = get_option('classic_blog_grid_is_premium', false);
?>

<div class="container-fluid">
    <div class="clbgd-wrap">
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="d-flex gap-3">
                    <img class="h-100" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/logo-icon.png'); ?>"
                        alt="<?php esc_attr_e('Icon', 'classic-blog-grid'); ?>">
                    <h2 class="clbgd-heading-cls">CLASSIC BLOG GRID</h2>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="clbgd-btn-wrap">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=clbgd_collections_templates')); ?>"
                        class="clbgd-btn">Themes</a>
                    <a href="<?php echo esc_url( CLBGD_SERVER_URL . 'products/classic-blog-grid-pro' ); ?>"
                        target="_blank" class="clbgd-btn">Go Pro</a>
                </div>
            </div>
            <div class="clbgd-border"></div>
        </div>
        <div class="wrap">
            <h1><?php echo esc_html($post_id ? __('Edit Grid', 'classic-blog-grid') : __('Add New Grid', 'classic-blog-grid')); ?>
            </h1>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('clbgd_save_grid', 'clbgd_nonce'); ?>
                <input type="hidden" name="action" value="<?php echo $is_premium_user ? 'clbgd_save_grid_pro' : 'clbgd_save_grid' ; ?>" />
                <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">

                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="grid_title"><?php esc_html_e('Grid Title', 'classic-blog-grid'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="grid_title" id="grid_title" class="regular-text" required
                                value="<?php echo esc_attr($grid_title); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="grid_layout"><?php esc_html_e('Grid Layout', 'classic-blog-grid'); ?></label>
                        </th>
                        <td>
                            <div class="grid-layout-options">

                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="list"
                                            <?php checked($grid_layout, 'list'); ?>>
                                        <p><?php esc_html_e('List Layout', 'classic-blog-grid'); ?></p><span class="pro-badge">Free</span>

                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout1.png'); ?>"
                                        alt="<?php esc_attr_e('List Layout', 'classic-blog-grid'); ?>">
                                </label>
                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="masonry"
                                            <?php checked($grid_layout, 'masonry'); ?>>
                                        <p><?php esc_html_e('Masonry Layout', 'classic-blog-grid'); ?></p><span class="pro-badge">Free</span>

                                    </div>

                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout2.png'); ?>"
                                        alt="<?php esc_attr_e('Masonry Layout', 'classic-blog-grid'); ?>">
                                </label>
                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="slider"
                                            <?php checked($grid_layout, 'slider'); ?>>
                                        <p><?php esc_html_e('Slider Layout', 'classic-blog-grid'); ?></p><span class="pro-badge">Free</span>

                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout3.png'); ?>"
                                        alt="<?php esc_attr_e('Slider Layout', 'classic-blog-grid'); ?>">
                                </label>


                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="slider-thumbnail"
                                            <?php checked($grid_layout, 'slider-thumbnail'); ?><?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p><?php esc_html_e('Slider Thumbnail Layout', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout4.png'); ?>"
                                        alt="<?php esc_attr_e('Slider Thumbnail Layout', 'classic-blog-grid'); ?>">

                                </label>
                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="box"
                                            <?php checked($grid_layout, 'box'); ?><?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p><?php esc_html_e('Grid Box Layout', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout5.png'); ?>"
                                        alt="<?php esc_attr_e('box', 'classic-blog-grid'); ?>">

                                </label>
                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="search-layout"
                                            <?php checked($grid_layout, 'search-layout'); ?><?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p><?php esc_html_e('Grid With search Bar Layout', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout6.png'); ?>"
                                        alt="<?php esc_attr_e('Grid With search Bar Layout', 'classic-blog-grid'); ?>">

                                </label>
                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="category-tab"
                                            <?php checked($grid_layout, 'category-tab'); ?><?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p><?php esc_html_e('Grid With Category Tab Layout', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout7.png'); ?>"
                                        alt="<?php esc_attr_e('category-tab', 'classic-blog-grid'); ?>">

                                </label>
                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="carousel"
                                            <?php checked($grid_layout, 'carousel'); ?><?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p><?php esc_html_e('Carousel Layout', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout8.png'); ?>"
                                        alt="<?php esc_attr_e('layout4', 'classic-blog-grid'); ?>">

                                </label>
                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="alternate-list"
                                            <?php checked($grid_layout, 'alternate-list'); ?><?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p><?php esc_html_e('Alternate List Layout', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout9.png'); ?>"
                                        alt="<?php esc_attr_e('alternate-list', 'classic-blog-grid'); ?>">

                                </label>
                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="timeline-list"
                                            <?php checked($grid_layout, 'timeline-list'); ?><?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p><?php esc_html_e('Timeline Layout', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout10.png'); ?>"
                                        alt="<?php esc_attr_e('timeline-list', 'classic-blog-grid'); ?>">

                                </label>
                                <label class="premium-feature">
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="category-sidebar"
                                            <?php checked($grid_layout, 'category-sidebar'); ?>
                                            <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p>
                                            <?php esc_html_e('Category Sidebar', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout11.png'); ?>"
                                        alt="<?php esc_attr_e('Grid with Category Sidebar Layout', 'classic-blog-grid'); ?>">

                                </label>

                                <label>
                                    <div class="grid-latout-options-label">
                                        <input type="radio" name="grid_layout" value="list-category"
                                            <?php checked($grid_layout, 'list-category'); ?><?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                        <p><?php esc_html_e('List with Category Sidebar Layout', 'classic-blog-grid'); ?>
                                            <?php echo clbgd_pro_badge(); ?>
                                        </p>
                                    </div>
                                    <img src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/layout12.png'); ?>"
                                        alt="<?php esc_attr_e('list-category', 'classic-blog-grid'); ?>">

                                </label>

                            </div>
                        </td>
                     </tr>
                    <tr>
                        <th scope="row">
                            <label
                                for="grid_layout"><?php esc_html_e('Layout Settings', 'classic-blog-grid'); ?></label>
                        </th>
                        <td>
                            <div class="settings-box">
                                <div class="settings-grid">
                                    <div class="settings-grid-label">
                                    <label for="posts_per_row">Number of Posts in a Column (Masonry Layout) 
                                    <span class="exclamatory-tooltip">Set the number of posts to display in a single row for the masonry layout.</span>
                                    </label>
                                        <input type="number" name="posts_per_row" id="posts_per_row" class="small-text"
                                            min="1" max="4" step="1"
                                            value="<?php echo esc_attr(isset($posts_per_row) ? $posts_per_row : '3'); ?>" />
                                    </div>
                                    <div class="settings-grid-label">
                                        <label for="posts_per_page">Display Posts Per Page
                                        <span class="exclamatory-tooltip">Set the number of posts to display per page for this grid.</span>
                                        </label>
                                        <input type="number" name="posts_per_page" id="posts_per_page"
                                            class="small-text" min="1" step="1" required
                                            value="<?php echo esc_attr(isset($posts_per_page) ? $posts_per_page : '10'); ?>" />
                                            
                                    </div>
                                    <!-- dropdown start -->
                                    <div class="custom-dropdown-box">
                                        <div class="custom-dropdown">
                                            <label for="sort_order">Sort Order
                                            <span class="exclamatory-tooltip">Set the order of posts .</span>
                                            </label>
                                            <div class="dropdown-container">

                                                <?php 
                                                $premium_options = [
                                                    "A-Z" => "Title A-Z",
                                                    "Z-A" => "Title Z-A",
                                                    "Modified" => "Last Modified Date",
                                                    "Popularity" => "Popularity (Number of Views)",
                                                    "Comment" => "Comment Count",
                                                    "Featured" => "Featured Posts First",
                                                    "Custom" => "Custom Post Meta",
                                                    "Randomly" => "Randomly (Shuffle Posts)",
                                                    "Author" => "Author Name",
                                                    "Taxonomy" => "Custom Taxonomy Terms",
                                                ];
                                    
                                                $selected_label = 'Select an option';
                                                if (!empty($sort_order)) {
                                                    if ($sort_order == 'DESC') {
                                                        $selected_label = 'Publish Date Ascending';
                                                    } elseif ($sort_order == 'ASC') {
                                                        $selected_label = 'Publish Date Descending';
                                                    } elseif (array_key_exists($sort_order, $premium_options)) {
                                                        $selected_label = $premium_options[$sort_order];
                                                    } else {
                                                        $selected_label = ucfirst(strtolower($sort_order));
                                                    }
                                                }
                                                ?>
                                                <button type="button" class="dropdown-toggle"><?php echo esc_html($selected_label); ?></button>
                                                <ul class="dropdown-menu">
                                                    <li data-value="DESC"
                                                        class="dropdown-item <?php echo $sort_order == 'DESC' ? 'selected' : ''; ?>">
                                                        Publish Date Ascending<span class="pro-badge">Free</span></li>
                                                    <li data-value="ASC"
                                                        class="dropdown-item <?php echo $sort_order == 'ASC' ? 'selected' : ''; ?>">
                                                        Publish Date Descending<span class="pro-badge">Free</span></li>

                                                    <?php 
                                                      foreach ($premium_options as $value => $label) { 
                                                          $disabled = !$is_premium_user ? 'disabled' : ''; 
                                                     ?>

                                                    <li data-value="<?php echo esc_attr($value); ?>"
                                                        class="dropdown-item pro-option <?php echo esc_attr($disabled); ?> <?php echo $sort_order == $value ? 'selected' : ''; ?>">

                                                        <?php echo esc_html($label); ?>
                                                        <?php echo clbgd_pro_badge(); ?>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <input type="hidden" name="sort_order" id="sort_order"
                                                value="<?php echo esc_attr($sort_order); ?>">
                                        </div>
                                    </div>


                                    <!-- dropdown end -->

                                    <div class="excerpt-length-box">
                                        <label for="tittle_length">Post Title Max Length
                                        <span class="exclamatory-tooltip">Set the maximum number of words.</span>
                                        </label>
                                        <?php $title_length = get_post_meta($post_id, '_clbgd_title_length', true); ?>
                                        <input type="number" name="title_length" id="title_length"
                                            class="small-text" min="1" step="1"
                                            value="<?php echo esc_attr($title_length); ?>" 
                                            placeholder="<?php esc_attr_e('No limit', 'classic-blog-grid'); ?>" />
                                    </div>

                                    <div class="excerpt-length-box">
                                        <label for="excerpt_length">Excerpt Length
                                        <span class="exclamatory-tooltip">Set the number of words for the post excerpt.</span>
                                        </label>
                                        <input type="number" name="excerpt_length" id="excerpt_length"
                                            class="small-text" min="10" step="1"
                                            value="<?php echo esc_attr(isset($excerpt_length) ? $excerpt_length : '10'); ?>" />
                                    </div>
                                    
                                    
                                    
                                </div>

                                <div class="settings-container">
                                    <!-- Column 1 - Metadata Options -->
                                    <div class="settings-column metadata-container">
                                        <label class="metadata-label">Metadata Options:</label>
                                        <div class="metadata-options">
                                            <label>
                                                <div class="metadata-option-label">
                                                    <input type="checkbox" name="show_date"
                                                        <?php checked($show_date, true); ?> > Show Date
                                                </div>
                                                <span class="pro-badge">Free</span>

                                            </label>
                                            <label>
                                                <div class="metadata-option-label">
                                                    <input type="checkbox" name="show_author"
                                                        <?php checked($show_author, true); ?>> Show Author
                                                </div>
                                                <span class="pro-badge">Free</span>

                                            </label>
                                            <label>
                                                <div class="metadata-option-label">
                                                    <input type="checkbox" name="show_excerpt"
                                                        <?php checked($show_excerpt, true); ?>> Show Excerpt
                                                </div>
                                                <span class="pro-badge">Free</span>

                                            </label>
                                            <label>
                                                <div class="metadata-option-label">
                                                    <input type="checkbox" name="show_read_more"
                                                        <?php checked($show_read_more, true); ?>> Show Read More Button
                                                </div>
                                                <span class="pro-badge">Free</span>

                                            </label>
                                            
                                            

                                            <label>
                                                <div class="metadata-option-label">
                                                    <input type="checkbox" name="show_categories"
                                                        <?php checked($show_categories, true); ?>> Show Category
                                                </div>
                                                <span class="pro-badge">Free</span>

                                            </label>
                                            <label>
                                                <div class="metadata-option-label">
                                                    <input type="checkbox" name="show_comments"
                                                        <?php checked($show_comments, true); ?>> Show Comment Count
                                                </div>
                                                <span class="pro-badge">Free</span>

                                            </label>

                                            <label>
                                                <div class="metadata-option-label">
                                                    <input type="checkbox" name="show_tags"
                                                        <?php checked($show_tags, 1); ?>
                                                        <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                                    Show Tags
                                                </div>
                                                <?php echo clbgd_pro_badge(); ?>
                                            </label>

                                            <label>
                                                <div class="metadata-option-label">
                                                    <input type="checkbox" name="show_social_share"
                                                        <?php checked($show_social_share, 1); ?>
                                                        <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                                    Show Social Share
                                                </div> 
                                                <?php echo clbgd_pro_badge(); ?>
                                            </label>

                                           

                                        </div>
                                    </div>

                                    <!-- Column 2 - Additional Settings -->
                                    <div class="settings-column">
                                        <!-- Display Search Box (PRO) -->
                                        <div class="option-row">
                                            <label for="display_search_box">Display Search Box:
                                                    <?php echo clbgd_pro_badge(); ?>
                                            </label>
                                            <div class="option-group">
                                                <label>
                                                    <input type="radio" name="display_search_box" value="enable"
                                                        <?php checked($display_search_box, 'enable'); ?>
                                                        <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                                    Enable
                                                </label>
                                                <label>
                                                    <input type="radio" name="display_search_box" value="disable"
                                                        <?php checked($display_search_box, 'disable'); ?>
                                                        <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                                    Disable
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="option-row">
                                            <label for="enable_sidebar_category_filter">Enable Sidebar Post Category Filter:
                                               
                                                    <?php echo clbgd_pro_badge(); ?>
                                            </label>
                                            <div class="option-group">
                                                <label>
                                                    <input type="radio" name="enable_sidebar_category_filter" value="enable"
                                                        <?php checked($enable_sidebar_category_filter, 'enable'); ?>
                                                        <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                                    Enable
                                                </label>
                                                <label>
                                                    <input type="radio" name="enable_sidebar_category_filter" value="disable"
                                                        <?php checked($enable_sidebar_category_filter, 'disable'); ?>
                                                        <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                                    Disable
                                                </label>
                                            </div>
                                        </div>

                                        <div class="option-row">
                                           <label for="enable_ajax_masonry">Enable AJAX Loading for Masonry Layout:</label>
                                           <div class="option-group">
                                               <label>
                                                   <input type="radio" name="enable_ajax_masonry" value="enable"
                                                       <?php checked($enable_ajax_masonry, 'enable'); ?>>
                                                   Enable
                                               </label>
                                               <label>
                                                   <input type="radio" name="enable_ajax_masonry" value="disable"
                                                       <?php checked($enable_ajax_masonry, 'disable'); ?>>
                                                   Disable
                                               </label>
                                           </div>
                                       </div>

                                       <!-- new add -->

                

                                       <div class="option-row">
                                            <label for="enable_sidebar_category_filter">Custom "Read More" Button Text:
                                               
                                                    <span class="pro-badge">Free</span>
                                            </label>
                                            <div class="option-group">
                                                <?php $custom_read_more_text = get_post_meta($post_id, '_clbgd_custom_read_more_text', true) ?: 'Read More'; ?>
                                                <input type="text" name="custom_read_more_text" id="custom_read_more_text" 
                                                       class="regular-text" 
                                                       value="<?php echo esc_attr($custom_read_more_text); ?>" 
                                                       placeholder="<?php esc_attr_e('Enter custom read more text', 'classic-blog-grid'); ?>" />
                                                
                                            </div>
                                        </div>
                                       <!-- new end -->
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label
                                for="grid_layout"><?php esc_html_e('Styling and Customization', 'classic-blog-grid'); ?></label>
                        </th>
                        <td>

                            <div class="styling-customization-settings">
                                <div class="styling-customization-grid">
                                    <!-- Featured Image Display -->
                                    <div
                                        class="styling-customization-row featured-image-display-options premium-feature">
                                        <label for="enable_featured_image">Featured Image Display</label>
                                        <div class="styling-customization-options">
                                            <label>
                                                <input type="radio" name="enable_featured_image" value="enable"
                                                    <?php checked($enable_featured_image, 'enable'); ?>> Enable
                                            </label>
                                            <label>
                                                <input type="radio" name="enable_featured_image" value="disable"
                                                    <?php checked($enable_featured_image, 'disable'); ?>> Disable
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Slider Animation -->
                                    <div class="styling-customization-row slider-animation-options premium-feature">
                                        <label for="slider_animation">Slider Animation 
                                        </label>
                                        <?php echo clbgd_pro_badge(); ?>
                                        <div class="styling-customization-options">
                                            <select name="slider_animation" id="slider_animation"
                                                <?php echo !$is_premium_user ? 'disabled' : ''; ?>>

                                                <option value="slide" <?php selected($slider_animation, 'slide'); ?>>
                                                    Slide</option>
                                                <option value="fade" <?php selected($slider_animation, 'fade'); ?>>Fade
                                                </option>
                                                
                                                <option value="cube" <?php selected($slider_animation, 'cube'); ?>>cube
                                                </option>
                                                <option value="coverflow"
                                                    <?php selected($slider_animation, 'coverflow'); ?>>coverflow
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- new one add for font -->
                                    <?php
                                    // List of font families 
                                    $font_families = [
                                        // Web-Safe Fonts
                                        'Roboto' => 'Roboto',
                                        'Open Sans' => 'Open Sans',
                                        'Lato' => 'Lato',
                                        'Montserrat' => 'Montserrat',
                                        'Poppins' => 'Poppins',
                                        'Nunito' => 'Nunito',
                                        'Oswald' => 'Oswald',
                                        'Raleway' => 'Raleway',
                                        'Merriweather' => 'Merriweather',
                                        'Playfair Display' => 'Playfair Display',
                                        'Source Sans Pro' => 'Source Sans Pro',
                                        'Ubuntu' => 'Ubuntu',
                                        'Work Sans' => 'Work Sans',
                                        'Inter' => 'Inter',
                                        'Fira Sans' => 'Fira Sans',
                                        'Titillium Web' => 'Titillium Web',
                                        'Quicksand' => 'Quicksand',
                                        'Sintony' => 'Sintony',
                                        'Teko' => 'Teko',
                                        'Play' => 'Play',
                                        'Crimson Pro' => 'Crimson Pro',
                                        'Asap' => 'Asap',
                                        'Overpass' => 'Overpass',
                                        'Sacramento' => 'Sacramento',
                                        'Josefin Sans' => 'Josefin Sans',
                                    ];
                                    
                                    // Set default font if not set
                                    $blog_title_font = isset($blog_title_font) ? $blog_title_font : 'Arial';
                                    $blog_excerpt_font = isset($blog_excerpt_font) ? $blog_excerpt_font : 'Arial';
                                    ?>
                                    <div class="styling-customization-row blog-title-font-options premium-feature">
                                        <label for="blog_title_font">Blog Title Font</label>
                                        <?php echo clbgd_pro_badge(); ?>
                                        <select name="blog_title_font" id="blog_title_font" <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                            <?php foreach ($font_families as $font_key => $font_name) : ?>
                                                <option value="<?php echo esc_attr($font_key); ?>" <?php selected($blog_title_font, $font_key); ?>>
                                                    <?php echo esc_html($font_name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    
                                        <label for="blog_title_font_size">Font Size (px)</label>
                                        <input type="number" name="blog_title_font_size" id="blog_title_font_size"
                                            class="small-text" min="10"
                                            value="<?php echo esc_attr($blog_title_font_size); ?>"
                                            <?php echo !$is_premium_user ? 'disabled' : ''; ?> />
                                    </div>
                                    
                                    <div class="styling-customization-row blog-excerpt-font-options premium-feature">
                                        <label for="blog_excerpt_font">Blog Excerpt Font</label>
                                        <?php echo clbgd_pro_badge(); ?>
                                        <select name="blog_excerpt_font" id="blog_excerpt_font" <?php echo !$is_premium_user ? 'disabled' : ''; ?>>
                                            <?php foreach ($font_families as $font_key => $font_name) : ?>
                                                <option value="<?php echo esc_attr($font_key); ?>" <?php selected($blog_excerpt_font, $font_key); ?>>
                                                    <?php echo esc_html($font_name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    
                                        <label for="blog_excerpt_font_size">Font Size (px)</label>
                                        <input type="number" name="blog_excerpt_font_size" id="blog_excerpt_font_size"
                                            class="small-text" min="10"
                                            value="<?php echo esc_attr($blog_excerpt_font_size); ?>"
                                            <?php echo !$is_premium_user ? 'disabled' : ''; ?> />
                                    </div>
                                     
                                    <!-- for font color -->                           
                                    <div class="styling-customization-row-box">
                                       <!-- new one end for font -->
                                       <div class="styling-customization-row global-font-color-option">
                                           <label for="tittle_font_color">Tittle Font Color</label><span class="pro-badge">Free</span>
                                           <input type="color" name="tittle_font_color" id="tittle_font_color"
                                               value="<?php echo esc_attr($tittle_font_color); ?>"
                                                />
                                       </div>
                                       
                                        <div class="styling-customization-row global-font-color-option">
                                            <label for="tittle_hover_color">Tittle Hover Color</label><span class="pro-badge">Free</span>
                                            <input type="color" name="tittle_hover_color" id="tittle_hover_color"
                                                value="<?php echo esc_attr($tittle_hover_color); ?>"
                                                 />
                                        </div>
                                    </div>

                                    <!-- new for hover -->
                                    <div class="styling-customization-row-box">
                                        <!-- Title Font Weight -->
                                        <div class="styling-customization-row global-font-weight-option">
                                            <label for="tittle_font_weight">Tittle Font Weight</label><span class="pro-badge">Free</span>
                                            <?php $tittle_font_weight = isset($tittle_font_weight) ? $tittle_font_weight : 'normal';?>
                                            <select name="tittle_font_weight" id="tittle_font_weight">
                                                <option value="normal" <?php selected($tittle_font_weight, 'normal'); ?>>Normal</option>
                                                <option value="bold" <?php selected($tittle_font_weight, 'bold'); ?>>Bold</option>
                                                <option value="100" <?php selected($tittle_font_weight, '100'); ?>>100</option>
                                                <option value="200" <?php selected($tittle_font_weight, '200'); ?>>200</option>
                                                <option value="300" <?php selected($tittle_font_weight, '300'); ?>>300</option>
                                                <option value="400" <?php selected($tittle_font_weight, '400'); ?>>400</option>
                                                <option value="500" <?php selected($tittle_font_weight, '500'); ?>>500</option>
                                                <option value="600" <?php selected($tittle_font_weight, '600'); ?>>600</option>
                                                <option value="700" <?php selected($tittle_font_weight, '700'); ?>>700</option>
                                                <option value="800" <?php selected($tittle_font_weight, '800'); ?>>800</option>
                                                <option value="900" <?php selected($tittle_font_weight, '900'); ?>>900</option>
                                            </select>
                                        </div>
                                     </div>
                                    <!-- end -->


                                    <div class="styling-customization-row-box">
                                       <!-- new one end for font -->
                                       <div class="styling-customization-row global-font-color-option">
                                           <label for="excerpt_font_color">Excerpt Font Color</label><span class="pro-badge">Free</span>
                                           <input type="color" name="excerpt_font_color" id="excerpt_font_color"
                                               value="<?php echo esc_attr($excerpt_font_color); ?>"
                                                />
                                       </div>

                                       <div class="styling-customization-row global-font-weight-option">
                                            <label for="excerpt_font_weight">Excerpt Font Weight</label><span class="pro-badge">Free</span>
                                           <?php $excerpt_font_weight = isset($excerpt_font_weight) ? $excerpt_font_weight : 'normal';?>
                                            <select name="excerpt_font_weight" id="excerpt_font_weight">
                                                <option value="normal" <?php selected($excerpt_font_weight, 'normal'); ?>>Normal</option>
                                                <option value="bold" <?php selected($excerpt_font_weight, 'bold'); ?>>Bold</option>
                                                <option value="100" <?php selected($excerpt_font_weight, '100'); ?>>100</option>
                                                <option value="200" <?php selected($excerpt_font_weight, '200'); ?>>200</option>
                                                <option value="300" <?php selected($excerpt_font_weight, '300'); ?>>300</option>
                                                <option value="400" <?php selected($excerpt_font_weight, '400'); ?>>400</option>
                                                <option value="500" <?php selected($excerpt_font_weight, '500'); ?>>500</option>
                                                <option value="600" <?php selected($excerpt_font_weight, '600'); ?>>600</option>
                                                <option value="700" <?php selected($excerpt_font_weight, '700'); ?>>700</option>
                                                <option value="800" <?php selected($excerpt_font_weight, '800'); ?>>800</option>
                                                <option value="900" <?php selected($excerpt_font_weight, '900'); ?>>900</option>
                                            </select>
                                        </div>
                                       
                                    </div>

                                    <!-- new for hover -->

                                    <div class="styling-customization-row-box">
                                       <!-- new one end for font -->
                                       <div class="styling-customization-row global-font-color-option">
                                           <label for="meta_font_color">Meta Data Font Color</label><span class="pro-badge">Free</span>
                                           <input type="color" name="meta_font_color" id="meta_font_color"
                                               value="<?php echo esc_attr($meta_font_color); ?>"
                                                />
                                       </div>

                                       <div class="styling-customization-row global-font-weight-option">
                                            <label for="meta_font_weight">Meta Data Font Weight</label><span class="pro-badge">Free</span>
                                            <?php $meta_font_weight = isset($meta_font_weight) ? $meta_font_weight : 'normal';?>
                                            <select name="meta_font_weight" id="meta_font_weight">
                                                <option value="normal" <?php selected($meta_font_weight, 'normal'); ?>>Normal</option>
                                                <option value="bold" <?php selected($meta_font_weight, 'bold'); ?>>Bold</option>
                                                <option value="100" <?php selected($meta_font_weight, '100'); ?>>100</option>
                                                <option value="200" <?php selected($meta_font_weight, '200'); ?>>200</option>
                                                <option value="300" <?php selected($meta_font_weight, '300'); ?>>300</option>
                                                <option value="400" <?php selected($meta_font_weight, '400'); ?>>400</option>
                                                <option value="500" <?php selected($meta_font_weight, '500'); ?>>500</option>
                                                <option value="600" <?php selected($meta_font_weight, '600'); ?>>600</option>
                                                <option value="700" <?php selected($meta_font_weight, '700'); ?>>700</option>
                                                <option value="800" <?php selected($meta_font_weight, '800'); ?>>800</option>
                                                <option value="900" <?php selected($meta_font_weight, '900'); ?>>900</option>
                                            </select>
                                        </div>
                                       
                                    </div>

                                    <!-- global -->
                                    <div class="styling-customization-row-box">
                                       <div class="styling-customization-row global-font-color-option">
                                           <label for="global_font_color">Button Font Color</label><span class="pro-badge">Free</span>
                                           <input type="color" name="global_font_color" id="global_font_color"
                                               value="<?php echo esc_attr($global_font_color); ?>"
                                                />
                                       </div>

                                      
                                       <div class="styling-customization-row global-button-bg-color-option">
                                            <label for="global_button_bg_color">Button Background Color</label><span class="pro-badge">Free</span>
                                            <input type="color" name="global_button_bg_color" id="global_button_bg_color"
                                                value="<?php echo esc_attr($global_button_bg_color); ?>" />
                                        </div>
                                    </div>


                                    <!-- new for buuton bg color -->

                                    <div class="styling-customization-row-box">
                                        

                                        <div class="styling-customization-row global-button-hover-bg-color-option">
                                            <label for="global_button_hover_bg_color">Button Hover Background Color</label><span class="pro-badge">Free</span>
                                            <input type="color" name="global_button_hover_bg_color" id="global_button_hover_bg_color"
                                                value="<?php echo esc_attr($global_button_hover_bg_color); ?>" />
                                        </div>

                                         <!-- new one end for font -->
                                       <div class="styling-customization-row grid-overlay-color-option">
                                          <label for="grid_overlay_color">Grid Overlay Color</label><?php echo clbgd_pro_badge(); ?>
                                          <input type="color" name="grid_overlay_color" id="grid_overlay_color"
                                              value="<?php echo esc_attr($grid_overlay_color); ?>"  <?php echo !$is_premium_user ? 'disabled' : ''; ?>/>
                                       </div>


                                    </div>

                                   
                                
                                    <!-- new -->
                                    <!-- Show Pagination -->
                                    <div class="styling-customization-row-box">
                                    <div class="styling-customization-row show-pagination-option">
                                        <label for="show_pagination"><?php esc_html_e('Show Pagination', 'classic-blog-grid'); ?></label>
                                        <span class="pro-badge">Free</span>
                                        <input type="checkbox" name="show_pagination" id="show_pagination" value="1"
                                            <?php checked(get_post_meta($post_id, '_clbgd_show_pagination', true), '1'); ?> />
                                        <label for="show_pagination"><?php esc_html_e('Enable pagination for post navigation.', 'classic-blog-grid'); ?></label>
                                       
                                    </div>
                                    </div>

                                    <!-- Image Aspect Ratio -->
                                    <div class="styling-customization-row-box">
                                    <div class="styling-customization-row image-aspect-ratio-option">
                                        <label for="image_aspect_ratio"><?php esc_html_e('Image Aspect Ratio', 'classic-blog-grid'); ?></label>
                                        <span class="pro-badge">Free</span>
                                        
                                            <select name="image_aspect_ratio" id="image_aspect_ratio">
                                                <?php $selected_ratio = get_post_meta($post_id, '_clbgd_image_aspect_ratio', true); ?>
                                                <option value="auto" <?php selected($selected_ratio, 'auto'); ?>><?php esc_html_e('Auto', 'classic-blog-grid'); ?></option>
                                                <option value="1-1" <?php selected($selected_ratio, '1-1'); ?>>1:1</option>
                                                <option value="16-9" <?php selected($selected_ratio, '16-9'); ?>>16:9</option>
                                                <option value="4-3" <?php selected($selected_ratio, '4-3'); ?>>4:3</option>
                                            </select>
                                      
                                    </div>
                                    </div>


                                    <!-- Include Categories or Tags -->
                                    <div class="styling-customization-row-box">
                                        <div class="styling-customization-row include-categories-option">
                                            <label for="include_categories_tags"><?php esc_html_e('Include Categories or Tags', 'classic-blog-grid'); ?></label>
                                            <span class="pro-badge">Free</span>
                                            <textarea name="include_categories_tags" id="include_categories_tags" rows="3" class="large-text"><?php echo esc_textarea(get_post_meta($post_id, '_clbgd_include_categories_tags', true)); ?></textarea>
                                            <p class="description mx-2"><?php esc_html_e('Enter category or tag slugs to include, separated by commas. E.g., news,tech', 'classic-blog-grid'); ?></p>
                                        </div>
                                    </div>

                                    <!-- Exclude Categories or Tags -->
                                    <div class="styling-customization-row-box">
                                        <div class="styling-customization-row exclude-categories-option">
                                            <label for="exclude_categories_tags"><?php esc_html_e('Exclude Categories or Tags', 'classic-blog-grid'); ?></label>
                                            <span class="pro-badge">Free</span>
                                            <textarea name="exclude_categories_tags" id="exclude_categories_tags" rows="3" class="large-text"><?php echo esc_textarea(get_post_meta($post_id, '_clbgd_exclude_categories_tags', true)); ?></textarea>
                                            <p class="description mx-2"><?php esc_html_e('Enter category or tag slugs to exclude, separated by commas. E.g., uncategorized,ads', 'classic-blog-grid'); ?></p>
                                        </div>
                                    </div>




                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="custom_css"><?php esc_html_e('Custom CSS', 'classic-blog-grid'); ?></label>
                        </th>
                        <td>


                        <textarea name="custom_css" id="custom_css" rows="6" class="large-text" 
                        <?php echo !$is_premium_user ? 'disabled' : ''; ?>><?php echo esc_textarea(get_post_meta($post_id, '_clbgd_custom_css', true)); ?></textarea>

                            <div class="custom-css-text">
                                <p class="description">
                                    <?php esc_html_e('Enter your custom CSS rules here. These will be applied globally.', 'classic-blog-grid'); ?>
                                </p>
                                <?php echo clbgd_pro_badge(); ?>
                            </div>

                        </td>
                    </tr>
                    <!-- end -->
                </table>
                <?php submit_button($post_id ? esc_html__('Update Grid', 'classic-blog-grid') : esc_html__('Add Grid', 'classic-blog-grid')); ?>
            </form>
        </div>
    </div>
</div>