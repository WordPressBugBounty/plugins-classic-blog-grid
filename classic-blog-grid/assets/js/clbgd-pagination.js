jQuery(document).ready(function($) {
 
    var isLoading = false;

    // $(window).scroll(function () {
    //     if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !isLoading) {            
    //         loadMoreProducts();
    //     }
    // });

    function productsAjax( endCursor, templateSearch, collection, actionValue ) {

        var progress = 0;
        var progressInterval = setInterval(function() {
            progress += 10;
            if (progress >= 100) {
                clearInterval(progressInterval);
            }
        }, 300);

        $.ajax({
            url: clbgd_pagination_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'clbgd_get_filtered_products',
                cursor: endCursor,
                search: templateSearch,
                collection: collection,
                clbgd_pagination_nonce: clbgd_pagination_object.nonce
            },
            success: function (response) {

                clearInterval(progressInterval);
                jQuery('.clbgd-loader').hide();
                jQuery('.clbgd-loader-overlay').hide();

                if (response.content) {

                    isLoading = false;

                    if ( actionValue != 'load' ) {
                        jQuery('.clbgd-filter-content.clbgd-main-grid').empty();
                    }
                    jQuery('.clbgd-filter-content.clbgd-main-grid').append(response.content);

                    const hasNextPage = response?.pagination?.hasNextPage;
                    const endCursor = response?.pagination?.endCursor;

                    jQuery('[name="clbgd-end-cursor"]').val(endCursor);
                    if (!hasNextPage) {
                        jQuery('[name="clbgd-end-cursor"]').val('');
                        jQuery('.clbgd-load-more').hide();
                        isLoading = true
                    }
                }
            },
            error: function () {
                
                clearInterval(progressInterval);
                jQuery('.clbgd-loader').hide();
                jQuery('.clbgd-loader-overlay').hide();

                console.log('Error loading products');
            }
        });
    }

    // function loadMoreProducts() {
    //     isLoading = true;

    //     const endCursor = jQuery('[name="clbgd-end-cursor"]').val();
    //     const templateSearch = jQuery('[name="clbgd-templates-search"]').val();
    //     const collection = jQuery('[name="clbgd-collections"]').val();

    //     productsAjax( endCursor, templateSearch, collection, 'load' );
    // }

    function debounce(func, delay) {
        let timeoutId;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(context, args);
            }, delay);
        };
    }

    jQuery('.clbgd-templates-collections-group li').on('click', function() {

        jQuery('.clbgd-loader').show();
        jQuery('.clbgd-loader-overlay').show();

        let category = '';
        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
        } else {
            jQuery('.clbgd-templates-collections-group li').removeClass('active');
            jQuery(this).addClass('active');
            
            category = jQuery(this).attr('data-value');
        }

        jQuery('.clbgd-templates-collections-group').removeClass('active');

        productsAjax( '', '', category, 'category' );
    });

    $('body').on("input", '[name="clbgd-templates-search"]', debounce(function (event) {

        const templateSearch = $('[name="clbgd-templates-search"]').val();

        jQuery('.clbgd-loader').show();
        jQuery('.clbgd-loader-overlay').show();
        
        productsAjax( '', templateSearch, '', 'search' );
        
    }, 1000));

    $('body').on("click", '.clbgd-load-more', function (event) {
        event.preventDefault();

        isLoading = true;
        const endCursor = jQuery('[name="clbgd-end-cursor"]').val();
        const templateSearch = jQuery('[name="clbgd-templates-search"]').val();
        const collection = jQuery('[name="clbgd-collections"]').val();

        productsAjax( endCursor, templateSearch, collection, 'load' );
    });

    $('body').on("click", '.clbgd-filter-category-select', function (event) {
        $('.clbgd-templates-collections-group').toggleClass('active');
    });
});