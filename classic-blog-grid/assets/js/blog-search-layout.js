jQuery(document).ready(function($) {

    function fetchSearchResults(searchValue, paged = 1) {
        var showDate = $('#clbgd-search-form').data('show-date');
        var showAuthor = $('#clbgd-search-form').data('show-author');
        var showComments = $('#clbgd-search-form').data('show-comments');
        var showExcerpt = $('#clbgd-search-form').data('show-excerpt');
        var excerptLength = $('#clbgd-search-form').data('excerpt-length');
        var showCategories = $('#clbgd-search-form').data('show-categories');
        var enableFeaturedImage = $('#clbgd-search-form').data('enable-featured-image');
        var postsPerPage = $('#clbgd-search-form').data('posts-per-page');

        var showtags = $('#clbgd-search-form').data('show-tags');
        var showsocialshare = $('#clbgd-search-form').data('show-social-share');

        // Get sort order
        var sortOrder = $('#clbgd-search-form').data('sort-order');


        $.ajax({
            url: clbgd_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'clbgd_search',
                search: searchValue,
                paged: paged, // Send page number
                show_date: showDate,
                show_author: showAuthor,
                show_comments: showComments,
                show_excerpt: showExcerpt,
                excerpt_length: excerptLength,
                show_categories: showCategories,
                enable_featured_image: enableFeaturedImage,
                posts_per_page: postsPerPage,
                show_tags: showtags,
                show_social_share : showsocialshare,
                sort_order: sortOrder 

            },
            beforeSend: function() {
                $('#clbgd-search-results').html('<p>Loading...</p>');
            },


            success: function(response) {
                if (response.success) {
                    $('#clbgd-search-results').html(response.data.html);
                    $('.clbgd-pagination').html(response.data.pagination); // Update pagination dynamically
                } else {
                    $('#clbgd-search-results').html('<p>' + response.data.message + '</p>');

                    $('.clbgd-pagination').html('');
                }
            }

           
        });
    }
    // Run on load 
   // fetchSearchResults(searchValue, paged = 1)
   // fetchSearchResults();

    // Handle form submission
    $('#clbgd-search-form').submit(function(e) {
        e.preventDefault();
        var searchValue = $('#clbgd-search-input').val();
        fetchSearchResults(searchValue);
    });

    // Handle pagination click
    $(document).on('click', '.clbgd-pagination a', function(e) {
        e.preventDefault();
        var searchValue = $('#clbgd-search-input').val();
        var href = $(this).attr('href');

        var paged = href.includes('paged=') ? href.split('paged=')[1] : 1;
        fetchSearchResults(searchValue, paged);
    });

    
});


