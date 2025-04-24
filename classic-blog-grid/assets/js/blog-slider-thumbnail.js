document.addEventListener("DOMContentLoaded", function () {
    var animationcheck = clbgdSliderSettings.animation;

    var thumbSwiper = new Swiper(".thumbnail-slider", {
        slidesPerView: 5,  
        spaceBetween: 10,  
        freeMode: true,    
        watchSlidesProgress: true,
        loop: false, // Disable loop for thumbnails
    });

    var mainSwiper = new Swiper(".main-slider", {
        slidesPerView: 1,
        spaceBetween: 0,
        effect: animationcheck,
        centeredSlides: true,
        loop: true,  
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        on: {
            slideChangeTransitionEnd: function () {
                // Get the correct index based on realIndex
                let correctIndex = mainSwiper.realIndex;

                // Sync the thumbnail slider to the main slider
                thumbSwiper.slideTo(correctIndex);

                // Remove active class from all thumbnails
                document.querySelectorAll(".thumbnail-image").forEach((el) => {
                    el.classList.remove("active-thumbnail");
                });

                // Add active class to the correct thumbnail
                if (document.querySelectorAll(".thumbnail-image")[correctIndex]) {
                    document.querySelectorAll(".thumbnail-image")[correctIndex].classList.add("active-thumbnail");
                }
            }
        }
    });

    // Set initial active thumbnail
    document.querySelectorAll(".thumbnail-image")[0].classList.add("active-thumbnail");
});
