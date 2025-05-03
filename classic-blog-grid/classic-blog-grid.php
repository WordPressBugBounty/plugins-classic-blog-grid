<?php
/**
 * Plugin Name:       Classic Blog Grid
 * Plugin URI:        https://www.theclassictemplates.com/products/classic-blog-grid-pro
 * Description:       A plugin to display blog posts in various grid formats: list, masonry, and slider.
 * Version:           1.5
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            classictemplate
 * Author URI:        https://www.theclassictemplates.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       classic-blog-grid
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

define( 'CLBGD_PLUGIN_VERSION', '1.5' );

define( 'CLBGD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CLBGD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CLBGD_API_URL', 'https://license.theclassictemplates.com/api/public/' );
define( 'CLBGD_SERVER_URL', 'https://www.theclassictemplates.com/' );

require_once CLBGD_PLUGIN_DIR . 'global-functions.php';
require_once CLBGD_PLUGIN_DIR . 'includes/class-classic-blog-grid-core.php';

function clbgd_init() {
    $clbgd_instance = Clbgd_Core::instance();
    $clbgd_instance->init();
}
add_action( 'plugins_loaded', 'clbgd_init' );

//new added for fontawsome 
function clbgd_enqueue_swiper_assets() {
    wp_enqueue_style(
        'swiper-css',
        CLBGD_PLUGIN_URL . 'assets/lib/css/swiper-bundle.min.css',
        array(),
        CLBGD_PLUGIN_VERSION
    );

    wp_enqueue_script(
        'swiper-js',
        CLBGD_PLUGIN_URL . 'assets/lib/js/swiper-bundle.min.js',
        array('jquery'),
        CLBGD_PLUGIN_VERSION,
        true
    );
     wp_enqueue_style('classic-blog-boot-css', CLBGD_PLUGIN_URL . 'assets/css/bootstrap.min.css', [], CLBGD_PLUGIN_VERSION);
     wp_enqueue_script('classic-blog-boot-css-js', CLBGD_PLUGIN_URL . 'assets/js/bootstrap.bundle.min.js', ['jquery'], CLBGD_PLUGIN_VERSION, true);
     wp_enqueue_style('font-awesome', CLBGD_PLUGIN_URL . 'assets/lib/css/fontawesome-all.min.css', array(), CLBGD_PLUGIN_VERSION);
     wp_enqueue_script('font-awesome', CLBGD_PLUGIN_URL . 'assets/lib/js/fontawesome-all.min.js', array(), CLBGD_PLUGIN_VERSION, true); 
}
add_action('wp_enqueue_scripts', 'clbgd_enqueue_swiper_assets');