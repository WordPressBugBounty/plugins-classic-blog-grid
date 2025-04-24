jQuery(document).ready(function ($) {
    var checkanimation = clbgdSliderSettings.animation;
    console.log(checkanimation);
    console.log(typeof checkanimation);

    var swiper = new Swiper("#clbgdSlider", {
        loop: true, 
        slidesPerView: 1, 
        spaceBetween: 10,
        effect: checkanimation, 
        loopAdditionalSlides: 1, 
        autoplay: {
            delay: 10000,
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
        on: {
            init: function () {
                var activeSlide = $(".swiper-slide-active");
                var bgImage = activeSlide.attr("data-bg");
                $("#clbgdSlider").css("background-image", "url(" + bgImage + ")");
            },
            slideChangeTransitionStart: function () {
                $("#clbgdSlider").addClass("swiper-transitioning");
            },
            slideChangeTransitionEnd: function () {
                var activeSlide = $(".swiper-slide-active");
                var bgImage = activeSlide.attr("data-bg");
                $("#clbgdSlider").css("background-image", "url(" + bgImage + ")");
                $("#clbgdSlider").removeClass("swiper-transitioning");
            },
            loopFix: function () {
                this.slides.forEach((slide) => {
                    slide.style.zIndex = "1";
                });
                document.querySelector(".swiper-slide-active").style.zIndex = "2";
            }
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-bg]").forEach(function (element) {
        let bg = element.getAttribute("data-bg");
        element.style.backgroundImage = `url('${bg}')`;
        element.classList.add("bg-image"); // Add CSS class for styling
    });
});