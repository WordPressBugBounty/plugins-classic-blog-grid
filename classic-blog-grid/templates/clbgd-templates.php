<div class="wrap clbgd-templates-wrap">
<div class="row">
        <div class="col-lg-8 col-md-6">
            <div class="d-flex gap-3">
                <img class="h-100" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/logo-icon.png'); ?>" alt="<?php esc_attr_e('Icon', 'classic-blog-grid'); ?>"> 
                <h2 class="clbgd-heading-cls">CLASSIC BLOG GRID</h2>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="clbgd-btn-wrap">
                <a href="<?php echo esc_url(admin_url('admin.php?page=classic-blog-grid')); ?>" class="clbgd-btn">Dashboard</a>
                <a href="<?php echo esc_url( CLBGD_SERVER_URL . 'products/classic-blog-grid-pro' ); ?>" target="_blank" class="clbgd-btn">Go Pro</a>
            </div>
        </div>
        <div class="clbgd-border"></div>
    </div>
    <div class="clbgd-loader"></div>
    <div class="clbgd-loader-overlay"></div>
    <div class="clbgd-templates-main">
        <div class="clbgd-filter-header row justify-content-center my-5">
            <div class="col-md-10 clbgd-filter-header-iner">
                <div class="clbgd-filter-categories-wrapper position-relative">
                    <div class="clbgd-filter-category-select">
                        <span class="clbgd-filter-category-select-content">Themes Categories</span>
                        <span class="dashicons dashicons-arrow-down"></span>
                    </div>
                    <ul class="clbgd-templates-collections-group">
                        <?php $collections_arr = clbgd_get_collections(); ?>
                        <?php foreach ( $collections_arr as $collection ) {
                            
                            if ($collection->handle != 'free-wordpress-themes' && $collection->handle != 'uncategorized' && $collection->handle != 'testing') { ?>
                                <li data-value="<?php echo esc_attr($collection->handle); ?>"><?php echo esc_html($collection->title); ?></li>
                            <?php } ?>
                            
                        <?php } ?>
                    </ul>
                </div>
                <div class="clbgd-templates-collections-search">
                    <div class=" d-flex gap-2">
                        <input type="text" name="clbgd-templates-search" autocomplete="off" placeholder="Search Templates...">
                        <span class="dashicons dashicons-search"></span>
                    </div>

                </div>
            </div>     
        </div>
        <div class="clbgd-templates-search-content-box row">
            <div class="col-md-8">                   
                <div class="clbgd-filter-content clbgd-main-grid row" id="clbgd-filter-content">
                    <?php $get_filtered_products = clbgd_get_filtered_products();
                        if (isset($get_filtered_products['products']) && !empty($get_filtered_products['products'])) {
                            foreach ( $get_filtered_products['products'] as $product ) {

                                $product_obj = $product->node;
                                
                                if (isset($product_obj->inCollection) && !$product_obj->inCollection || $product_obj->title == 'Testing' || $product_obj->title == 'Theme Extra Customizations') {
                                    continue;
                                }

                                $demo_url = isset($product->node->metafield->value) ? $product->node->metafield->value : '';
                                $product_url = isset($product->node->onlineStoreUrl) ? $product->node->onlineStoreUrl : '';
                                $image_src = isset($product->node->images->edges[0]->node->src) ? $product->node->images->edges[0]->node->src : ''; ?>

                                <div class="clbgd-item clbgd-filter-free col-xl-4 col-lg-6 col-12 mb-4">
                                    <div class="clbgd-item-inner-box">                              
                                        <div class="clbgd-item-preview">
                                            <div class="clbgd-item-screenshot">
                                                <img src="<?php echo esc_url($image_src); ?>" loading="lazy" alt="<?php echo esc_attr($product_obj->title); ?>">
                                                <div class="clbgd-item-overlay">
                                                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clbgd-item-footer">
                                            <div class="clbgd-item-footer_meta">
                                                <h3 class="theme-name"><?php echo esc_html($product_obj->title); ?></h3>
                                                <p class="theme-seo-title"><?php echo esc_html($product_obj->seo->title); ?></p>
                                                <div class="clbgd-item-footer-actions d-flex justify-content-center gap-2">
                                                    <a class="clbgd-buy-now clbgd-btn" href="<?php echo esc_attr($product_url); ?>" aria-label="Buy Now"><?php echo esc_html('Buy Now'); ?></a>
                                                    <?php if ( $demo_url != '' ) { ?>
                                                        <a class="clbgd-item-demo-link clbgd-btn" href="<?php echo esc_attr($demo_url); ?>" target="_blank"><?php echo esc_html('Demo'); ?></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    ?>
                </div>
                <?php if (isset($get_filtered_products['pagination']->hasNextPage) && $get_filtered_products['pagination']->hasNextPage) { ?>
                    <a href="#" class="clbgd-load-more" name="clbgd-end-cursor" data-pagination="<?php echo esc_attr(isset($get_filtered_products['pagination']->endCursor) ? $get_filtered_products['pagination']->endCursor : '') ?>">Load More</a>
                    <input type="hidden" name="clbgd-end-cursor" value="<?php echo esc_attr(isset($get_filtered_products['pagination']->endCursor) ? $get_filtered_products['pagination']->endCursor : '') ?>">
                <?php } ?>
            </div> 
            <div class="col-md-4">
                <div class="template-banner-box">
                    <img class="w-100" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/template-banner.png'); ?>" alt="<?php esc_attr_e('List Layout', 'classic-blog-grid'); ?>">     
                    <div class="clbgd-tem-content-wrap d-flex flex-column gap-3 text-center">
                        <h3 class="clbgd-tem-content-banner-heading">WordPress Theme Bundle</h3>
                        <p class="clbgd-tem-content-banner-para">Discover the WordPress Theme Bundle from The Classic Templates with 100+ stunning themes for any niche!</p>
                        <div class="clbgd-banner-price-wrap d-flex justify-content-center gap-3">
                            <h6>Price:</h6>
                            <h6 class="decorative-price position-relative">$2,045</h6>
                            <h6 class="clbgd-banner-regular-price">$99</h6>
                        </div>
                        <div class="clbgd-tem-banner-points row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="d-flex flex-column gap-2">
                                    <p class="gap-2 d-flex align-items-center"><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> 100+ Professionally Themes</p>
                                    <p class="gap-2 d-flex align-items-center"><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Fully Responsive Design</p>
                                    <p class="gap-2 d-flex align-items-center"><img  class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Easy Customization Tools</p>
                                </div>
                            </div>
                            <div class="col-lg-6  col-md-12 col-sm-12 col-12">
                                <div class="d-flex flex-column gap-2">
                                    <p class="gap-2 d-flex align-items-center"><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> SEO-Friendly Features</p>
                                    <p class="gap-2 d-flex align-items-center"><img class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Regular Updates</p>
                                    <p class="gap-2 d-flex align-items-center"><img  class="check-icon" src="<?php echo esc_url(CLBGD_PLUGIN_URL . 'assets/images/check.svg'); ?>" alt="<?php esc_attr_e('check', 'classic-blog-grid'); ?>"> Dedicated Customer Support</p>
                                </div>
                            </div>
                        </div>
                        <div class="clbgd-tem-content-banner-btn-wrap d-flex justify-content-center">
                            <a href="<?php echo esc_url( CLBGD_SERVER_URL . 'products/wordpress-theme-bundle' ); ?>" target="_blank" class="clbgd-banner-btn clbgd-btn">Purchase Now</a>
                            <a href="<?php echo esc_url( CLBGD_SERVER_URL . 'collections/best-wordpress-templates' ); ?>" target="_blank" class="clbgd-banner-btn clbgd-btn">Live Preview</a>
                        </div>
                    </div>    
                </div>  
            </div>
        </div>
    </div>
</div>