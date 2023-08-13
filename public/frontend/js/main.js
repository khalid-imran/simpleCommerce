(function($) {
    "use strict";

    /* Cart search */
    $(".account-satting-active , .search-active").on("click", function(e) {
        e.preventDefault();
        $(this).parent().find('.account-dropdown , .search-content').slideToggle('medium');
    })

    /* Cart dropdown */
    var iconCart = $('.icon-cart');
    iconCart.on('click', function() {
        $('.shopping-cart-content').toggleClass('cart-visible');
    })

    /*--------------------------
        ScrollUp
    ---------------------------- */
    $.scrollUp({
        scrollText: '<i class="fa fa-angle-double-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });

    /*--
Menu Stick
-----------------------------------*/
    var header = $('.sticky-bar');
    var win = $(window);
    win.on('scroll', function() {
        var scroll = win.scrollTop();
        if (scroll < 200) {
            header.removeClass('stick');
        } else {
            header.addClass('stick');
        }
    })

    /* jQuery MeanMenu */
    $('#mobile-menu-active').meanmenu({
        meanScreenWidth: "991",
        meanMenuContainer: ".mobile-menu-area .mobile-menu",
    });

    window.sr = ScrollReveal({
        duration: 1000,
        reset: false
    });

})(jQuery);
