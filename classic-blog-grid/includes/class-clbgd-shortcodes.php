<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Clbgd_Shortcodes {
    private static $instance = null;

    //Singleton Pattern 
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_shortcode('clbgd', array($this, 'clbgd_render_blog_grid'));
    }

    public function clbgd_render_blog_grid($atts) {
        $atts = shortcode_atts(array('id' => ''), $atts, 'clbgd');
        $post_id = $atts['id'];

        $meta_values = $this->get_post_meta_values($post_id);

        //new add 


        switch ($meta_values['grid_layout']) {
            case 'masonry':
                return $this->render_grid('masonry', $meta_values, $post_id);
            case 'slider':
                return $this->render_grid('slider', $meta_values, $post_id);
            case 'slider-thumbnail':
                return $this->render_grid('slider-thumbnail', $meta_values, $post_id);
            case 'search-layout':
                return $this->render_grid('search-layout', $meta_values, $post_id);    
            case 'category-sidebar':
                return $this->render_grid('category-sidebar', $meta_values, $post_id);                 
            case 'carousel':
                return $this->render_grid('carousel', $meta_values, $post_id); 
            case 'category-tab':
                return $this->render_grid('category-tab', $meta_values, $post_id);  
            case 'list-category':
                return $this->render_grid('list-category', $meta_values, $post_id); 
            case 'box':
                return $this->render_grid('box', $meta_values, $post_id);           
            case 'alternate-list':
                return $this->render_grid('alternate-list', $meta_values, $post_id);  
            case 'timeline-list':
                return $this->render_grid('timeline-list', $meta_values, $post_id);                   
            default:
                return $this->render_grid('list', $meta_values, $post_id);
        }
    }

    private function get_post_meta_values($post_id) {
        return array(
            'grid_layout'        => get_post_meta($post_id, '_clbgd_grid_layout', true),
            'sort_order'         => get_post_meta($post_id, '_clbgd_sort_order', true) ?: 'DESC',
            'show_date'          => get_post_meta($post_id, '_clbgd_show_date', true),
            'show_author'        => get_post_meta($post_id, '_clbgd_show_author', true),
            'show_excerpt'       => get_post_meta($post_id, '_clbgd_show_excerpt', true),
            'excerpt_length'     => get_post_meta($post_id, '_clbgd_excerpt_length', true),
            'show_categories'    => get_post_meta($post_id, '_clbgd_show_categories', true),
            'show_comments'      => get_post_meta($post_id, '_clbgd_show_comments', true),
            'posts_per_row'      => get_post_meta($post_id, '_clbgd_posts_per_row', true),
            'enable_featured_image' => get_post_meta($post_id, '_clbgd_enable_featured_image', true) ?: 'disable',

            'title_font_family' => get_post_meta($post_id, "_clbgd_blog_title_font", true) ?: 'Arial',
            'title_font_size'   => get_post_meta($post_id, "_clbgd_blog_title_font_size", true) ?: '',
            'excerpt_font_family' => get_post_meta($post_id, "_clbgd_blog_excerpt_font", true) ?: 'Arial',
            'excerpt_font_size' => get_post_meta($post_id, "_clbgd_blog_excerpt_font_size", true) ?: '',

            'custom_css' => get_post_meta($post_id, '_clbgd_custom_css', true) ?: '',


            '_clbgd_display_search_box' => get_post_meta($post_id, '_clbgd_display_search_box', true) ?: '',
            '_clbgd_enable_sidebar_category_filter' => get_post_meta($post_id, '_clbgd_enable_sidebar_category_filter', true) ?: '',

            // 'show_date'          => get_post_meta($post_id, '_clbgd_show_tags', true),
            'show_tags'        => get_post_meta($post_id, '_clbgd_show_tags', true) ?: '',

            'show_social_share'        => get_post_meta($post_id, '_clbgd_show_social_share', true),

            'font_color' => get_post_meta($post_id, '_clbgd_global_font_color', true) ?: '#000',

            'grid_overlay_color' => get_post_meta($post_id, '_clbgd_grid_overlay_color', true) ?: '#000',
            


        );
    }


    private function render_grid($type, $meta_values, $post_id) 
    {
        $styles = array(
            'list'    => 'blog-list',
            'slider'  => 'blog-slider',
            'masonry' => 'blog-masonry',
            'slider-thumbnail'  => 'blog-slider-thumbnail',
            'search-layout'  => 'blog-search-layout',
            'category-sidebar'  => 'blog-category-sidebar',
            'carousel' => 'blog-carousel',   
            'category-tab' => 'blog-category-tab',  
            'list-category' => 'blog-list-category',
            'box'    => 'blog-box',
            'alternate-list'    => 'blog-alternate-list',
            'timeline-list' => 'blog-timeline-list',
        );

        $style_file = CLBGD_PLUGIN_URL . "assets/css/{$styles[$type]}.css";
        $script_file = CLBGD_PLUGIN_URL . "assets/js/{$styles[$type]}.js";
        
        wp_enqueue_script('masonry');
        wp_enqueue_script('imagesloaded');

        wp_enqueue_style("clbgd-{$styles[$type]}-css", $style_file, array(), CLBGD_PLUGIN_VERSION);
        wp_enqueue_script("clbgd-{$styles[$type]}-js", $script_file, array('jquery', 'masonry'), CLBGD_PLUGIN_VERSION, true);



        //new one add 
        $blog_font_css = "
        .clbgd-blog-post-title2, 
        .clbgd-blog-post-excerpt2, 
        .clbgd-blog-post-content2 { 
            color: " . esc_attr($meta_values['font_color']) . " ; 
        }
        .clbgd-blog-post-content2 a { 
            color: " . esc_attr($meta_values['font_color']) . " ; 
          }

        .clbgd-blog-post-title2 {
            font-family: {$meta_values['title_font_family']}, sans-serif !important;
            font-size: {$meta_values['title_font_size']}px !important;
        }
        .clbgd-blog-post-excerpt2 {
            font-family: {$meta_values['excerpt_font_family']}, sans-serif !important;
            font-size: {$meta_values['excerpt_font_size']}px !important;
        }

        .masonry-item-overlay {
            background: " . esc_attr($meta_values['grid_overlay_color']) . " !important;
        }

         .slider-item-overlay {
            background: " . esc_attr($meta_values['grid_overlay_color']) . " !important;
        }
               .slider-thambnail-item-overlay {
            background: " . esc_attr($meta_values['grid_overlay_color']) . " !important;
        }
        .carousel-item-overlay {
            background: " . esc_attr($meta_values['grid_overlay_color']) . " !important;
        }

          .timeline-item-overlay {
            background: " . esc_attr($meta_values['grid_overlay_color']) . " !important;
        }
    ";
    wp_add_inline_style("clbgd-{$styles[$type]}-css", $blog_font_css);


    // new add '
      // Add inline styles for masonry layout
      if ($type === 'masonry') {
          $masonry_css = "
              .masonry-container {
                  column-count: " . esc_attr($meta_values['posts_per_row']) . ";
                  column-gap: 20px;
              }
          ";
          wp_add_inline_style("clbgd-{$styles[$type]}-css", $masonry_css);
      }
    //end


    
    //custom css
    if (!empty($meta_values['custom_css'])) {
        wp_add_inline_style("clbgd-{$styles[$type]}-css", $meta_values['custom_css']);
    }
    //end 

         wp_localize_script("clbgd-{$styles[$type]}-js", 'clbgd_ajax', array(
             'ajaxurl' => admin_url('admin-ajax.php')
         ));

    
        // Add inline CSS for masonry layout
        if ($type === 'masonry') {
            $inline_css = sprintf(
                '.clbgd-masonry-container {
                    column-count: %d;
                    column-gap: 20px; /* Adjust as needed */
                }
                #clbgd-masonryLayout.clbgd-masonry-container {
                    display: grid;
                    grid-template-columns: repeat(%d, 1fr);
                    gap: 20px;
                    padding: 20px;
                }',
                $meta_values['posts_per_row'],
                $meta_values['posts_per_row']
            );
            wp_add_inline_style('clbgd-blog-masonry-css', $inline_css);
        }


        // pass the animation 
        if ($type === 'slider' || $type === 'slider-thumbnail') {
            $slider_animation = get_post_meta($post_id, '_clbgd_slider_animation', true);
        
            if (!$slider_animation) {
                $slider_animation = 'slide'; 
            }
        
            wp_localize_script("clbgd-{$styles[$type]}-js", 'clbgdSliderSettings', array(
                'animation' => $slider_animation,
                'security' => wp_create_nonce('clbgd_ajax_nonce')
            ));
        }
        //end 

        // Load  template
        ob_start();
        $meta_values = $meta_values; 
        $post_id = $post_id; 
        include CLBGD_PLUGIN_DIR . "templates/blog-{$type}.php";
        return ob_get_clean();
    }
}

//Initialize the singleton instance
Clbgd_Shortcodes::get_instance();

