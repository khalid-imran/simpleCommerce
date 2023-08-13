<template>
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3 mb-5">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <router-link :to="{name: 'dashboard'}">Home</router-link>
                    </li>
                    <li class="active"><a href="javascript:void(0)" class="active">Shop</a> </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-60" >
            <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6" v-for="l in allProducts">
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
</template>

<script>
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
import store from "../../Store/store";

export default {
    name: "product",
    data() {
        return {
            APP_URL: window.APP_URL,
            allProducts: []
        }
    },
    computed: {
        auth: function () {
            return store.getters.GetAuth
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
                    $('.shopping-cart-content').addClass('cart-visible');
                }
            });
        },
        getAllProducts: function () {
            ApiService.POST(ApiRoutes.ProductAll, null,(res) => {
                if (parseInt(res.status) === 200) {
                    this.allProducts = res.data
                    setTimeout(() => {
                        sr.reveal('.scroll-zoom');
                    }, 1)
                }
            });
        },
    },
    created() {
        this.getAllProducts()
    }
}
</script>
