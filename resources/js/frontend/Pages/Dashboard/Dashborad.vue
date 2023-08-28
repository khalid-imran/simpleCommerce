<template>
    <div class="slider-area ml-70 mr-70">
        <div class="slider-active owl-carousel nav-style-1 owl-dot-none">
            <div  v-for="s in settings?.slide" class="single-slider-2 slider-height-1 d-flex align-items-center slider-height-res bg-img"
                  :style="{ 'backgroundImage': 'url(' + s.full_path + ')' }">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-7 ms-auto">
                            <div class="slider-content-2 slider-animated-1">
                                <h1 class="animated">{{ s.title}}</h1>
                                <div class="slider-btn btn-hover">
                                    <router-link class="animated uppercase" :to="{name: 'products'}">{{ s.button_title }}</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="banner-area pt-60 pb-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="javascript:void(0)"><img src="images/banner-1.jpg" alt></a>
                        <div class="banner-content">
                            <h3>Watches</h3>
                            <h4>Starting at <span>$99.00</span></h4>
                            <a href="javascript:void(0)"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="javascript:void(0)"><img src="images/banner-2.jpg" alt></a>
                        <div class="banner-content">
                            <h3>Plo Bag</h3>
                            <h4>Starting at <span>$79.00</span></h4>
                            <a href="javascript:void(0)"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="javascript:void(0)"><img src="images/banner-3.jpg" alt></a>
                        <div class="banner-content">
                            <h3>Sunglass</h3>
                            <h4>Starting at <span>$79.00</span></h4>
                            <a href="javascript:void(0)"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="product-area pt-60 pb-60">
        <div class="container">
            <h3 class="text-center mb-4">New Arrivals  </h3>
            <div class="row mb-60" >
                <div class="col-xl-4 col-md-6 col-lg-4 col-sm-6" v-for="l in latestProducts">
                    <div class="product-wrap mb-25 scroll-zoom">
                        <div class="product-img">
                            <router-link :to="{name: 'productSingle', params: {slug: l.slug}}">
                                <img class="default-img" v-if="l.images.length > 0" :src="l.images[0].full_path" alt="">
                                <img class="default-img" v-else src="images/product_default.jpg" alt="">
                                <img class="hover-img" v-if="l.images.length > 1" :src="l.images[1].full_path" alt="">
                            </router-link>
                            <span class="pink" v-if="l.discount_type == 1">-{{ l.discount_amount }}%</span>
                            <div class="product-action">
                                <div class="pro-same-action pro-wishlist">
                                    <a title="Wishlist" href="#"><i class="pe-7s-like"></i></a>
                                </div>
                                <div class="pro-same-action pro-cart">
                                    <a @click="addToCart(l)" title="Add To Cart" href="javascript:void(0)">
                                        <i v-if="!l.loading" class="pe-7s-cart"></i>
                                        <i v-if="l.loading" class="fa fa-spin fa-spinner"></i>
                                        Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content text-center">
                            <h3><router-link :to="{name: 'productSingle', params: {slug: l.slug}}">{{l.title}}</router-link></h3>
                            <div class="product-price">
                                <span>৳ {{getPrice(l).reduce_price}}</span>
                                <span class="old" v-if="l.discount_type != 2">৳ {{ getPrice(l).price }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-area pt-60 pb-60">
        <div class="container">
            <h3 class="text-center mb-4">Tranding  </h3>
            <div class="row mb-60" >
                <div class="col-xl-4 col-md-6 col-lg-4 col-sm-6" v-for="l in trandingProducts">
                    <div class="product-wrap mb-25 scroll-zoom">
                        <div class="product-img">
                            <router-link :to="{name: 'productSingle', params: {slug: l.slug}}">
                                <img class="default-img" v-if="l.images.length > 0" :src="l.images[0].full_path" alt="">
                                <img class="default-img" v-else src="images/product_default.jpg" alt="">
                                <img class="hover-img" v-if="l.images.length > 1" :src="l.images[1].full_path" alt="">
                            </router-link>
                            <span class="pink" v-if="l.discount_type == 1">-{{ l.discount_amount }}%</span>
                            <div class="product-action">
                                <div class="pro-same-action pro-wishlist">
                                    <a title="Wishlist" href="#"><i class="pe-7s-like"></i></a>
                                </div>
                                <div class="pro-same-action pro-cart">
                                    <a @click="addToCart(l)" title="Add To Cart" href="javascript:void(0)">
                                        <i v-if="!l.loading" class="pe-7s-cart"></i>
                                        <i v-if="l.loading" class="fa fa-spin fa-spinner"></i>
                                        Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content text-center">
                            <h3><router-link :to="{name: 'productSingle', params: {slug: l.slug}}">{{l.title}}</router-link></h3>
                            <div class="product-price">
                                <span>৳ {{getPrice(l).reduce_price}}</span>
                                <span class="old" v-if="l.discount_type != 2">৳ {{ getPrice(l).price }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-area pt-60 pb-60">
        <div class="container">
            <h3 class="text-center mb-4">Upcoming  </h3>
            <div class="row mb-60" >
                <div class="col-xl-4 col-md-6 col-lg-4 col-sm-6" v-for="l in upcomingProducts">
                    <div class="product-wrap mb-25 scroll-zoom">
                        <div class="product-img">
                            <a href="javascript:void(0)">
                                <img class="default-img" v-if="l.images.length > 0" :src="l.images[0].full_path" alt="">
                                <img class="default-img" v-else src="images/product_default.jpg" alt="">
                                <img class="hover-img" v-if="l.images.length > 1" :src="l.images[1].full_path" alt="">
                            </a>
                            <span class="pink" v-if="l.discount_type == 1">-{{ l.discount_amount }}%</span>
<!--                            <div class="product-action">-->
<!--                                <div class="pro-same-action pro-cart w-100">-->
<!--                                    <a title="Interested" href="javascript:void(0)">-->
<!--                                        <i v-if="l.loading" class="fa fa-spin fa-spinner"></i>-->
<!--                                        Interested</a>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                        <div class="product-content text-center">
                            <h3><a href="javascript:void(0)">{{l.title}}</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import store from "../../Store/store";
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";

export default {
    name: "Dashborad",
    data: function () {
        return {
            latestProducts: [],
            trandingProducts: [],
            upcomingProducts: [],
        }
    },
    computed: {
        settings: function () {
            return store.getters.GetWebsite
        },
        auth: function () {
            return store.getters.GetAuthUser
        },
        guest: function () {
            return store.getters.GetGuest
        }
    },
    methods: {
        addToCart: function (product) {
            if (this.auth == null && this.guest == null) {
                this.createGuest(product)
            } else {
                this.cartRequestToServer(product)
            }
        },
        createGuest: function (product) {
            ApiService.POST(ApiRoutes.CreateGuest, null,(res) => {
                if (parseInt(res.status) === 200) {
                    this.$store.commit('PutGuest', res.guest);
                    this.cartRequestToServer(product)
                }
            });
        },
        cartRequestToServer: function (product) {
            product.loading = true
            let param = {
                product_id: product.id,
                variant_id: product.variants[0].id
            }
            if (this.guest) {
                param.guest_user_id = this.guest.uid
            }
            ApiService.POST(ApiRoutes.AddCart, param,(res) => {
                product.loading = false
                if (parseInt(res.status) === 200) {
                    this.getCart()
                }
            });
        },
        getCart: function () {
            let param = {}
            if (this.guest) {
                param.guest_user_id = this.guest.uid
            }
            ApiService.POST(ApiRoutes.GetCart, param,(res) => {
                if (parseInt(res.status) === 200) {
                    this.$store.commit('PutCartData', res.data);
                    setTimeout(() => {
                        $('.shopping-cart-content').addClass('cart-visible');
                    }, 500)
                }
            });
        },
        getLatestProduct: function () {
            ApiService.POST(ApiRoutes.ProductLatest, null,(res) => {
                if (parseInt(res.status) === 200) {
                    this.latestProducts = res.data
                    setTimeout(() => {
                        sr.reveal('.scroll-zoom');
                    }, 1)
                }
            });
        },
        getTrandingProduct: function () {
            ApiService.POST(ApiRoutes.ProductTranding, null,(res) => {
                if (parseInt(res.status) === 200) {
                    this.trandingProducts = res.data
                    setTimeout(() => {
                        sr.reveal('.scroll-zoom');
                    }, 1)
                }
            });
        },
        getUpcomingProduct: function () {
            ApiService.POST(ApiRoutes.ProductUpcoming, null,(res) => {
                if (parseInt(res.status) === 200) {
                    this.upcomingProducts = res.data
                    setTimeout(() => {
                        sr.reveal('.scroll-zoom');
                    }, 1)
                }
            });
        },
    },
    created: function () {
        this.getLatestProduct()
        this.getTrandingProduct()
        this.getUpcomingProduct()
    },
    mounted() {
        setTimeout(() => {
            /* Slider active */
            $('.slider-active').owlCarousel({
                loop: true,
                nav: true,
                autoplay: false,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                autoplayTimeout: 5000,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                item: 1,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            })
        }, 100)
    }
}
</script>

<style scoped>

</style>
