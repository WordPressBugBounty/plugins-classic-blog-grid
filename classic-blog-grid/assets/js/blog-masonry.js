document.addEventListener("DOMContentLoaded", function () {
    var grid = document.getElementById("masonry-grid");

    if (grid) {
        imagesLoaded(grid, function () {
            new Masonry(grid, {
                itemSelector: ".masonry-item",
                columnWidth: ".masonry-item",
                gutter: 20,
                fitWidth: true,
                percentPosition: true
            });
        });
    }
});

//

jQuery(document).ready(function($) {
    let page = 1;
    const loadMoreBtn = $('#load-more');
    const maxPages = parseInt(loadMoreBtn.data('max-pages'));
    const postId = loadMoreBtn.data('post-id');

    loadMoreBtn.on('click', function() {
        page++;

        $.ajax({
            url: clbgd_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_posts',
                page: page,
                post_id: postId,

                show_date: loadMoreBtn.data('show-date'),
                show_author: loadMoreBtn.data('show-author'),
                show_categories: loadMoreBtn.data('show-categories'),
                show_excerpt: loadMoreBtn.data('show-excerpt'),
                show_tags: loadMoreBtn.data('show-tags'),
                excerpt_length: loadMoreBtn.data('excerpt-length'),


                show_comments: loadMoreBtn.data('show-comments'),

                sort_order: loadMoreBtn.data('sort-order'),

                enable_featured_image: loadMoreBtn.data('enable-featured-image'),
                posts_per_page: loadMoreBtn.data('posts-per-page'),
                show_social_share: loadMoreBtn.data('show-social-share')



            },
            beforeSend: function() {
                loadMoreBtn.text('Loading...').prop('disabled', true);
            },
            success: function(response) {
                if (response.success && response.data) {
                    $('.masonry-container').append(response.data);

                    if (page >= maxPages) {
                        loadMoreBtn.text('No More Posts').prop('disabled', true);
                    } else {
                        loadMoreBtn.text('Load More').prop('disabled', false);
                    }
                } else {
                    loadMoreBtn.text('No More Posts').prop('disabled', true);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                loadMoreBtn.text('Failed. Try Again').prop('disabled', false);
            }
        });
    });
});





