/**
 * WEBSITE: https://themefisher.com
 * TWITTER: https://twitter.com/themefisher
 * FACEBOOK: https://www.facebook.com/themefisher
 * GITHUB: https://github.com/themefisher/
 */

(function($) {
    'use strict';

    // ----------------------------
    // AOS
    // ----------------------------
    AOS.init({
        once: true
    });


    $(window).on('scroll', function() {
        //.Scroll to top show/hide
        var scrollToTop = $('.scroll-top-to'),
            scroll = $(window).scrollTop();
        if (scroll >= 200) {
            scrollToTop.fadeIn(200);
        } else {
            scrollToTop.fadeOut(100);
        }
    });
    // scroll-to-top
    $('.scroll-top-to').on('click', function() {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });

    $(document).ready(function() {

        // navbarDropdown
        if ($(window).width() < 992) {
            $('.main-nav .dropdown-toggle').on('click', function() {
                $(this).siblings('.dropdown-menu').animate({
                    height: 'toggle'
                }, 300);
            });
        }


        // -----------------------------
        //  Video Replace
        // -----------------------------
        $('.video-box i').click(function() {
            var video = '<iframe class="border-0" allowfullscreen src="' + $(this).attr('data-video') + '"></iframe>';
            $(this).replaceWith(video);
        });

        // scroll
        // $('.scrollTo').on('click', function (e) {
        //   e.preventDefault();
        //   var target = $(this).attr('href');
        //   $('html, body').animate({
        //     scrollTop: ($(target).offset().top)
        //   }, 500);
        // });

    });

})(jQuery);