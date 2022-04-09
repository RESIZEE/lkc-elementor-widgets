/* You can add your JS scripts for frontend here. */
// $('.news-widget').slick({
//     infinite: true,
//     slidesToShow: 3,
//     slidesToScroll: 3
// });

const $jq = jQuery.noConflict();

$jq(document).ready(function () {
    $jq('.news-widget-container').slick({
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
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});