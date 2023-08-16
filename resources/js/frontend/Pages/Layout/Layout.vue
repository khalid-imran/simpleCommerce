<template>
    <Header/>
    <router-view></router-view>
    <Footer/>
</template>

<script>
import Header from "../Shared/Header.vue";
import Footer from "../Shared/Footer.vue";
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
export default {
    components: {Header, Footer},
    methods: {
        getWebsite: function () {
            ApiService.POST(ApiRoutes.Website, null,(res) => {
                this.dataLoading = false
                if (parseInt(res.status) === 200) {
                    this.$store.commit('PutWebsite', res.data);
                }
            });
        },
    },
    created() {
        this.getWebsite()
    },
    mounted() {
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

            setTimeout(() => {
                /*--------------------------
              ScrollUp
          ---------------------------- */
                $.scrollUp({
                    scrollText: '<i class="fa fa-angle-double-up"></i>',
                    easingType: 'linear',
                    scrollSpeed: 900,
                    animation: 'fade'
                });
            }, 1000)

        })(jQuery);
    }
}
</script>

<style lang="scss">

</style>
