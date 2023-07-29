<template>
    <div class="slider-area ml-70 mr-70">
        <div class="slider-active owl-carousel nav-style-1 owl-dot-none">
            <div  v-for="s in settings?.slide" class="single-slider-2 slider-height-1 d-flex align-items-center slider-height-res bg-img"
                  :style="{ 'background-image': 'url(' + s.full_path + ')' }">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-7 ms-auto">
                            <div class="slider-content-2 slider-animated-1">
                                <h1 class="animated">{{ s.title}}</h1>
                                <div class="slider-btn btn-hover">
                                    <router-link class="animated uppercase" :to="{name: 'product'}">{{ s.button_title }}</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-area pt-60 pb-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="product-details.html"><img src="images/banner-1.jpg" alt></a>
                        <div class="banner-content">
                            <h3>Watches</h3>
                            <h4>Starting at <span>$99.00</span></h4>
                            <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="product-details.html"><img src="images/banner-2.jpg" alt></a>
                        <div class="banner-content">
                            <h3>Plo Bag</h3>
                            <h4>Starting at <span>$79.00</span></h4>
                            <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30">
                        <a href="product-details.html"><img src="images/banner-3.jpg" alt></a>
                        <div class="banner-content">
                            <h3>Sunglass</h3>
                            <h4>Starting at <span>$79.00</span></h4>
                            <a href="product-details.html"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-area pb-60">
        <div class="container">
            <h4 class="text-center mb-4">New Arrivals  </h4>
            <div class="row mb-60" >
                <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6">
                    <div class="product-wrap mb-25">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img class="default-img" src="images/hm2-pro-1.jpg" alt="">
                                <img class="hover-img" src="images/hm2-pro-8.jpg" alt="">
                            </a>
                            <span class="pink">-10%</span>
                            <div class="product-action">
                                <div class="pro-same-action pro-wishlist">
                                    <a title="Wishlist" href="#"><i class="pe-7s-like"></i></a>
                                </div>
                                <div class="pro-same-action pro-cart">
                                    <a title="Add To Cart" href="#"><i class="pe-7s-cart"></i> Add to cart</a>
                                </div>
                                <div class="pro-same-action pro-quickview">
                                    <a title="Quick View" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="pe-7s-look"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content text-center">
                            <h3><a href="product-details.html">T- Shirt And Jeans</a></h3>
                            <div class="product-price">
                                <span>$ 60.00</span>
                                <span class="old">$ 60.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="text-center mb-4">Best Sellers </h4>
            <div class="row mb-60" >
                <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6">
                    <div class="product-wrap mb-25">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img class="default-img" src="images/hm2-pro-1.jpg" alt="">
                                <img class="hover-img" src="images/hm2-pro-8.jpg" alt="">
                            </a>
                            <span class="pink">-10%</span>
                            <div class="product-action">
                                <div class="pro-same-action pro-wishlist">
                                    <a title="Wishlist" href="#"><i class="pe-7s-like"></i></a>
                                </div>
                                <div class="pro-same-action pro-cart">
                                    <a title="Add To Cart" href="#"><i class="pe-7s-cart"></i> Add to cart</a>
                                </div>
                                <div class="pro-same-action pro-quickview">
                                    <a title="Quick View" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="pe-7s-look"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content text-center">
                            <h3><a href="product-details.html">T- Shirt And Jeans</a></h3>
                            <div class="product-price">
                                <span>$ 60.00</span>
                                <span class="old">$ 60.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import store from "../../Store/store";

export default {
    name: "Dashborad",
    computed: {
        settings: function () {
            return store.getters.GetWebsite
        }
    }
}
</script>

<style scoped>

</style>
