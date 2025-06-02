<?php
if (!defined('ABSPATH')) {
    exit;
}

class Clbgd_Core
{

    private static $instance;

    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        $this->includes();
        $this->register_hooks();
    }


    private function includes()
    {
        require_once CLBGD_PLUGIN_DIR . 'includes/class-clbgd-shortcodes.php';
        require_once CLBGD_PLUGIN_DIR . 'includes/clbgd-search-results.php';
        require_once CLBGD_PLUGIN_DIR . 'includes/clbgd-masonary-load.php';
    }


    private function register_hooks()
    {
        add_action('init', array($this, 'clbgd_register_post_type'));
        add_action('admin_menu', array($this, 'clbgd_register_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'clbgd_load_admin_assets'));
        add_action('admin_post_clbgd_save_grid', array($this, 'clbgd_handle_save_grid'));
        add_filter('get_edit_post_link', array($this, 'clbgd_grid_edit_link'), 10, 3);
        add_filter('post_row_actions', array($this, 'clbgd_add_new_grid_link'), 10, 2);
        add_filter('admin_url', array($this, 'clbgd_redirect_add_new_grid'), 10, 2);
        add_filter('manage_clbgd_grid_posts_columns', array($this, 'clbgd_add_shortcode_column'));
        add_action('manage_clbgd_grid_posts_custom_column', array($this, 'clbgd_display_shortcode_column'), 10, 2);
    }

    public function clbgd_load_admin_assets($hook)
    {
        $current_screen = get_current_screen();
        if (strpos($current_screen->id, 'classic-blog-grid') !== false || $current_screen->post_type === 'clbgd_grid') {
            remove_all_actions('admin_notices');
            remove_all_actions('all_admin_notices');
            wp_enqueue_style('clbgd-admin-css', CLBGD_PLUGIN_URL . 'assets/css/admin-styles.css', array(), CLBGD_PLUGIN_VERSION);
            wp_enqueue_style('clbgd-admin-boostrap-css', CLBGD_PLUGIN_URL . 'assets/css/bootstrap.min.css', array(), CLBGD_PLUGIN_VERSION);
            wp_enqueue_script('clbgd-pagination-js', CLBGD_PLUGIN_URL . 'assets/js/clbgd-pagination.js', array('jquery'), CLBGD_PLUGIN_VERSION, true);


            wp_enqueue_style('font-awesome-dash', CLBGD_PLUGIN_URL . 'assets/lib/css/fontawesome-all.min.css', array(), CLBGD_PLUGIN_VERSION);
            // wp_enqueue_script('font-awesome-dash', CLBGD_PLUGIN_URL . 'assets/lib/js/fontawesome-all.min.js', array(), CLBGD_PLUGIN_VERSION, true);
            wp_localize_script('clbgd-pagination-js', 'clbgd_pagination_object', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('clbgd_create_pagination_nonce_action')
            ));
        }
        wp_enqueue_style('clbgd-admin-dashboard-css', CLBGD_PLUGIN_URL . 'assets/css/admin-dashboard.css', array(), CLBGD_PLUGIN_VERSION);
        wp_enqueue_script('clbgd-admin-js', CLBGD_PLUGIN_URL . 'assets/js/admin-scripts.js', array('jquery'), CLBGD_PLUGIN_VERSION, true);
        wp_localize_script('clbgd-admin-js', 'clbgd_admin_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('clbgd_dismiss_nonce')
        ));
    }

    //for edit link
    public function clbgd_grid_edit_link($link, $post_id, $context)
    {
        $post = get_post($post_id);

        if ($post->post_type === 'clbgd_grid') {
            return admin_url('admin.php?page=clbgd_add_new_grid&post_id=' . $post_id);
        }

        return $link;
    }

    // For custom row action
    public function clbgd_add_new_grid_link($actions, $post)
    {
        if ('clbgd_grid' === $post->post_type) {
            $actions['clbgd_custom_edit'] = '<a href="' . admin_url('admin.php?page=clbgd_add_new_grid&post_id=' . $post->ID) . '">Edit Grid</a>';
        }
        return $actions;
    }


    public function clbgd_redirect_add_new_grid($url, $path)
    {
        if ($path === 'post-new.php?post_type=clbgd_grid') {
            $url = admin_url('admin.php?page=clbgd_add_new_grid');
        }
        return $url;
    }


    public function clbgd_add_shortcode_column($columns)
    {
        $new_columns = array();
        foreach ($columns as $key => $column) {
            $new_columns[$key] = $column;
            if ('title' === $key) {
                $new_columns['clbgd_grid_shortcode'] = __('Shortcode', 'classic-blog-grid');
            }
        }
        foreach ($columns as $key => $column) {
            if ('title' !== $key) {
                $new_columns[$key] = $column;
            }
        }

        return $new_columns;
    }



    public function clbgd_display_shortcode_column($column, $post_id)
    {
        if ($column === 'clbgd_grid_shortcode') {
            echo esc_html('[clbgd id="' . $post_id . '"]');
        }
    }


    public function clbgd_register_post_type()
    {
        register_post_type('clbgd_grid', array(
            'labels' => array(
                'name' => __('Grids', 'classic-blog-grid'),
                'singular_name' => __('Grid', 'classic-blog-grid'),
                'add_new' => __('Add New Grid', 'classic-blog-grid'),
                'add_new_item' => __('Add New Grid', 'classic-blog-grid'),
                'edit_item' => __('Edit Grid', 'classic-blog-grid'),
                'new_item' => __('New Grid', 'classic-blog-grid'),
                'view_item' => __('View Grid', 'classic-blog-grid'),
                'search_items' => __('Search Grids', 'classic-blog-grid'),
                'not_found' => __('No grids found', 'classic-blog-grid'),
                'not_found_in_trash' => __('No grids found in Trash', 'classic-blog-grid'),
            ),
            'public' => true,
            'show_in_menu' => false,
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'grids'),
        ));
    }

    public function clbgd_register_admin_menu()
    {
        add_menu_page(
            __('Classic Blog Grid', 'classic-blog-grid'),
            __('Classic Blog Grid', 'classic-blog-grid'),
            'manage_options',
            'classic-blog-grid',
            array($this, 'render_main_menu_page'),
            'dashicons-screenoptions',
            20
        );

        add_submenu_page(
            'classic-blog-grid',
            __('All Grids', 'classic-blog-grid'),
            __('All Grids', 'classic-blog-grid'),
            'manage_options',
            'edit.php?post_type=clbgd_grid'
        );

        add_submenu_page(
            'classic-blog-grid',
            __('Add New Grid', 'classic-blog-grid'),
            __('Add New Grid', 'classic-blog-grid'),
            'manage_options',
            'clbgd_add_new_grid',
            array($this, 'render_add_new_grid_page')
        );

        add_submenu_page(
            'classic-blog-grid',
            __('Templates', 'classic-blog-grid'),
            __('Templates', 'classic-blog-grid'),
            'manage_options',
            'clbgd_collections_templates',
            array($this, 'render_collections_templates_page')
        );


        //new add
        if (is_plugin_active('classic-blog-grid-pro/classic-blog-grid-pro.php')) {
            add_submenu_page(
                'classic-blog-grid',
                __('License Key', 'classic-blog-grid'),
                __('License Key', 'classic-blog-grid'),
                'manage_options',
                'license-key',
                'clbgd_license_key_page'
            );
        }

        //end
    }

    public function render_main_menu_page()
    {
        include CLBGD_PLUGIN_DIR . 'templates/clbgd-dashboard.php';
    }

    public function render_collections_templates_page()
    {
        include CLBGD_PLUGIN_DIR . 'templates/clbgd-templates.php';
    }

    public function render_add_new_grid_page()
    {
        $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
        $grid_title = '';
        $grid_layout = 'list';
        $posts_per_page = 10;
        $sort_order = 'DESC';
        $show_date = 1;
        $show_author = 1;
        $show_excerpt = 1;
        $excerpt_length = 15;
        $show_categories = 0;
        $posts_per_row = 3;

        if ($post_id) {
            $post = get_post($post_id);
            if ($post && $post->post_type === 'clbgd_grid') {
                $grid_title = $post->post_title;
                $grid_layout = get_post_meta($post_id, '_clbgd_grid_layout', true);
                $posts_per_page = get_post_meta($post_id, '_clbgd_posts_per_page', true);
                $sort_order = get_post_meta($post_id, '_clbgd_sort_order', true);
                $show_date = get_post_meta($post_id, '_clbgd_show_date', true);
                $show_author = get_post_meta($post_id, '_clbgd_show_author', true);
                $show_excerpt = get_post_meta($post_id, '_clbgd_show_excerpt', true);
                $excerpt_length = get_post_meta($post_id, '_clbgd_excerpt_length', true);
                $show_categories = get_post_meta($post_id, '_clbgd_show_categories', true) ?: 0;
                $show_comments = get_post_meta($post_id, '_clbgd_show_comments', true) ?: 0;
                $posts_per_row = get_post_meta($post_id, '_clbgd_posts_per_row', true) ?: 3;
                $enable_featured_image = get_post_meta($post_id, '_clbgd_enable_featured_image', true);
                $enable_ajax_masonry = get_post_meta($post_id, '_clbgd_enable_ajax_masonry', true);
                $slider_animation = get_post_meta($post_id, '_clbgd_slider_animation', true) ?: 'fade';
                $global_font_color = get_post_meta($post_id, '_clbgd_global_font_color', true);
                $grid_overlay_color = get_post_meta($post_id, '_clbgd_grid_overlay_color', true);
                //new
                $tittle_font_color = get_post_meta($post_id, '_clbgd_tittle_font_color', true);
                $tittle_hover_color = get_post_meta($post_id, '_clbgd_tittle_hover_color', true);
                $tittle_font_weight = get_post_meta($post_id, '_clbgd_tittle_font_weight', true);
                $excerpt_font_color = get_post_meta($post_id, '_clbgd_excerpt_font_color', true);
                $excerpt_font_weight = get_post_meta($post_id, '_clbgd_excerpt_font_weight', true);
                $meta_font_color = get_post_meta($post_id, '_clbgd_meta_font_color', true);
                $meta_font_weight = get_post_meta($post_id, '_clbgd_meta_font_weight', true);

            }
        }

        include CLBGD_PLUGIN_DIR . 'templates/add-new-grid-form.php';
    }


    //save function 
    public function clbgd_handle_save_grid()
    {
        if (!isset($_POST['clbgd_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['clbgd_nonce'])), 'clbgd_save_grid')) {
            wp_die_esc_html((__('Security check failed.', 'classic-blog-grid')));
        }

        if (!current_user_can('manage_options')) {
            wp_die_esc_html((__('Insufficient permissions.', 'classic-blog-grid')));
        }

        $grid_title = sanitize_text_field($_POST['grid_title']);
        $grid_layout = sanitize_text_field($_POST['grid_layout']);
        $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 10;
        $sort_order = sanitize_text_field($_POST['sort_order']);
        $show_date = isset($_POST['show_date']) ? 1 : 0;
        $show_author = isset($_POST['show_author']) ? 1 : 0;
        $show_excerpt = isset($_POST['show_excerpt']) ? 1 : 0;
        $excerpt_length = isset($_POST['excerpt_length']) ? intval($_POST['excerpt_length']) : 15;
        $show_categories = isset($_POST['show_categories']) ? 1 : 0;
        $show_comments = isset($_POST['show_comments']) ? 1 : 0;
        $posts_per_row = isset($_POST['posts_per_row']) ? intval($_POST['posts_per_row']) : 2;
        // new setting
        $enable_featured_image = isset($_POST['enable_featured_image']) ? sanitize_text_field($_POST['enable_featured_image']) : 'enable';
        $global_font_color = isset($_POST['global_font_color']) ? sanitize_hex_color($_POST['global_font_color']) : '';
        $enable_ajax_masonry = isset($_POST['enable_ajax_masonry']) ? sanitize_text_field($_POST['enable_ajax_masonry']) : 'disable';
        // new added 
        $tittle_font_color = isset($_POST['tittle_font_color']) ? sanitize_hex_color($_POST['tittle_font_color']) : '';
        $tittle_hover_color = isset($_POST['tittle_hover_color']) ? sanitize_hex_color($_POST['tittle_hover_color']) : '';
        $tittle_font_weight = isset($_POST['tittle_font_weight']) ? sanitize_text_field($_POST['tittle_font_weight']) : '';
        $excerpt_font_color = isset($_POST['excerpt_font_color']) ? sanitize_hex_color($_POST['excerpt_font_color']) : '';
        $excerpt_font_weight = isset($_POST['excerpt_font_weight']) ? sanitize_text_field($_POST['excerpt_font_weight']) : '';
        $meta_font_color = isset($_POST['meta_font_color']) ? sanitize_hex_color($_POST['meta_font_color']) : '';
        $meta_font_weight = isset($_POST['meta_font_weight']) ? sanitize_text_field($_POST['meta_font_weight']) : '';

        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $post_data = array(
            'ID' => $post_id,
            'post_title' => $grid_title,
            'post_type' => 'clbgd_grid',
            'post_status' => 'publish',
        );
        $post_id = wp_insert_post($post_data);

        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_clbgd_grid_layout', $grid_layout);
            update_post_meta($post_id, '_clbgd_posts_per_page', $posts_per_page);
            update_post_meta($post_id, '_clbgd_sort_order', $sort_order);
            update_post_meta($post_id, '_clbgd_show_date', $show_date);
            update_post_meta($post_id, '_clbgd_show_author', $show_author);
            update_post_meta($post_id, '_clbgd_show_excerpt', $show_excerpt);
            update_post_meta($post_id, '_clbgd_excerpt_length', $excerpt_length);
            update_post_meta($post_id, '_clbgd_show_categories', $show_categories);
            update_post_meta($post_id, '_clbgd_show_comments', $show_comments);
            update_post_meta($post_id, '_clbgd_posts_per_row', $posts_per_row);
            update_post_meta($post_id, '_clbgd_enable_ajax_masonry', $enable_ajax_masonry);
            //new setting
            update_post_meta($post_id, '_clbgd_enable_featured_image', $enable_featured_image);
            update_post_meta($post_id, '_clbgd_global_font_color', $global_font_color);
            update_post_meta($post_id, '_clbgd_tittle_font_color', $tittle_font_color);
            update_post_meta($post_id, '_clbgd_tittle_hover_color', $tittle_hover_color);
            update_post_meta($post_id, '_clbgd_tittle_font_weight', $tittle_font_weight);
            update_post_meta($post_id, '_clbgd_excerpt_font_color', $excerpt_font_color);
            update_post_meta($post_id, '_clbgd_excerpt_font_weight', $excerpt_font_weight);
            update_post_meta($post_id, '_clbgd_meta_font_color', $meta_font_color);
            update_post_meta($post_id, '_clbgd_meta_font_weight', $meta_font_weight);
        }

        wp_redirect(admin_url('edit.php?post_type=clbgd_grid'));
        exit;
    }
}