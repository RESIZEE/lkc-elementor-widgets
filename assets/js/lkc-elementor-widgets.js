/* You can add your JS scripts for frontend here. */
/*
    Slick Carousel Script
 */
const $jq = jQuery.noConflict();

$jq(document).ready(function() {
    $jq('.news-widget-container')
        .on('init', function(event, slick) {
            $jq('.news-widget__count');
            if(slick.breakpoint < 480) {
                $jq('.current').text(slick.currentSlide + 1);
            } else if(slick.breakpoint < 1024) {
                $jq('.current').text(slick.currentSlide + 2);
            } else {
                $jq('.current').text(slick.currentSlide + 3);
            }
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
        .on('beforeChange', function(event, slick, currentSlide, nextSlide) {
            if(slick.breakpoint < 480) {
                $jq('.current').text(nextSlide + 1);
            } else if(slick.breakpoint < 1024) {
                $jq('.current').text(nextSlide + 2);
            } else {
                $jq('.current').text(nextSlide + 3);
            }
        });
});