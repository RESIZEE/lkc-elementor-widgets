/* You can add your JS scripts for frontend here. */
/*
    Slick Carousel Script
 */
const $jq = jQuery.noConflict();

$jq(document).ready(function() {
    // News slick carousel
    $jq('.news-widget-container')
        .on('init', function(event, slick) {
            $jq('.news-widget__count .current').text(slick.currentSlide + slick.options.slidesToShow);
            $jq('.total').text(slick.slideCount);
        })
        .slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            appendArrows: $jq('.news-widget__arrows'),
            prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        })
        .on('afterChange', function(event, slick, currentSlide, nextSlide) {
            $jq('.news-widget__count .current').text(currentSlide + slick.options.slidesToShow);
        });

    // Cinema movies slick carousel
    $jq('.cinema-movies-showcase-wrapper')
        .slick({
            responsive: [
                {
                    breakpoint: 2000,
                    settings: "unslick",
                },
                {
                    breakpoint: 1600,
                    settings: "unslick",
                },
                {
                    breakpoint: 1024,
                    settings: "unslick",
                },
                {
                    breakpoint: 600,
                    settings: "unslick",
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        slidesToShow: 1,
                        centerPadding: "30px",
                    },
                },
            ],
        });

    //Hero slick carouser
    $jq('.hero-slider-container').slick({
        infinite: true,
        speed: 900,
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: true,
        appendArrows: $jq('.hero-slider-controls'),
        prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',

    });
});

