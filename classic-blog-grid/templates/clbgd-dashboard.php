<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="container-fluid">
<div class="clbgd-wrap">
    <div class="row">
        <div class="col-lg-8 col-md-6">
        <div class="d-flex gap-3">
                <img class="h-100" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/logo-icon.png'); ?>" alt="<?php esc_attr_e('Icon', 'classic-blog-grid'); ?>"> 
                <h2 class="clbgd-heading-cls">CLASSIC BLOG GRID</h2>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="clbgd-btn-wrap">
                <a href="<?php echo esc_url(admin_url('admin.php?page=clbgd_collections_templates')); ?>" class="clbgd-btn">Themes</a>
                <a href="<?php echo esc_url( CLBGD_SERVER_URL . 'products/classic-blog-grid-pro' ); ?>" target="_blank" class="clbgd-btn">Go Pro</a>
            </div>
        </div>
        <div class="clbgd-border"></div>
    </div>
    <div class="py-2">
        <h1 class="wp-heading-inline py-2">Welcome to Classic Blog Grid</h1>
        <p class="para">Bring your blog to life with stunning grid layouts. Create beautiful list, masonry, and slider layouts to display your blog posts.</p>
    </div>
    <div class="row">
        <!-- Quick Stats Section -->
        <div class="clbgd-postbox col-md-4">
            <div class="clbgd-postbox-inner">
                <h2 class="clbgd-hndle"><span>Quick Stats</span></h2>
                <div class="clbgd-inside d-flex flex-column gap-2">
                    <?php
                    $total_grids = wp_count_posts('clbgd_grid')->publish;

                    $recent_activity = get_posts(array(
                        'post_type' => 'clbgd_grid',
                        'numberposts' => 1,
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ));
                    $recent_time = !empty($recent_activity) ? human_time_diff(get_the_time('U', $recent_activity[0]), current_time('timestamp')) . ' ago' : 'No recent updates';
                    $total_grids_draft = wp_count_posts('clbgd_grid')->draft;
                    $total_grids_pending = wp_count_posts('clbgd_grid')->pending;
                    ?>
                    
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Total Grids Created: <?php echo esc_html($total_grids); ?></p>
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Recent Activity: <?php echo esc_html($recent_time); ?></p>
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Grids in Draft: <?php echo esc_html($total_grids_draft); ?></p>
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Grids Pending Review: <?php echo esc_html($total_grids_pending); ?></p>
                </div>
            </div>       
        </div>

        <div class="clbgd-postbox col-md-5">
            <div class="clbgd-postbox-inner">
                <h2 class="clbgd-hndle"><span>Features</span></h2>
                <div class="clbgd-inside d-flex flex-column gap-2">
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> 3 grid layout types: List, Masonry, Slider</p>
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Fully responsive design</p>
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Customizable grid spacing & colors</p>
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Seamless integration with WordPress themes</p>
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Smooth animations for grid transitions</p>
                </div>
            </div>
        </div>

        <div class="clbgd-postbox col-md-3">
            <div class="clbgd-postbox-inner">
                <h2 class="clbgd-hndle"><span>Grid Layouts</span></h2>
                <div class="clbgd-inside d-flex flex-column gap-2">
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Grid 1 - Masonry Layout</p>
                    <p><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Grid 2 - List Layout</p>
                    <p><img  class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Grid 3 - Slider Layout</p>
                </div>
            </div>
        </div>
    </div>
    <div class="clbgd-banner">
     <div class="row align-items-center">
        <div class="col-lg-5 col-md-5">
         <img class="w-100" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/dashboard-banner.png'); ?>" alt="<?php esc_attr_e('List Layout', 'classic-blog-grid'); ?>">
        </div>
        <div class="col-lg-7 col-md-7">
            <div class="clbgd-content-wrap d-flex flex-column gap-3 text-center">
                <h3 class="clbgd-banner-heading">WordPress Theme Bundle </h3>
                <p class="clbgd-banner-para">Discover the WordPress Theme Bundle from The Classic Templates with 100+ stunning themes for any niche!</p>
                <div class="clbgd-banner-btn-wrap">
                    <a href="<?php echo esc_url( CLBGD_SERVER_URL . 'products/wordpress-theme-bundle' ); ?>" target="_blank" class="clbgd-banner-btn clbgd-btn">Purchase Now</a>
                    <a href="<?php echo esc_url( CLBGD_SERVER_URL . 'collections/best-wordpress-templates' ); ?>" target="_blank" class="clbgd-banner-btn clbgd-btn">Live Preview</a>
                </div>
            </div>          
        </div>
     </div>
    </div>
    <footer class="clbgd-plugin-footer">
        <p>Classic Blog Grid Version <?php echo CLBGD_PLUGIN_VERSION; ?> | Developed by Classic Templates</p>
    </footer>
</div>
</div>