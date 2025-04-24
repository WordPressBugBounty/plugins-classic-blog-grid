jQuery(document).ready(function ($) {
    var swiper = new Swiper("#clbgdCarousel", {
        loop: true,
        slidesPerView: 3, // Show 3 slides at once
        spaceBetween: 20, // Space between slides
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            1024: { slidesPerView: 3, spaceBetween: 20 }, // Desktop
            768: { slidesPerView: 2, spaceBetween: 15 }, // Tablet
            320: { slidesPerView: 1, spaceBetween: 10 } // Mobile
        }
    });
});