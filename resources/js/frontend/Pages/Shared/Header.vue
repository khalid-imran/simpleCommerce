<template>
    <header class="header-area header-padding-2 sticky-bar header-res-padding clearfix">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                    <div class="logo">
                        <router-link :to="{name: 'dashboard'}">
                            <img alt :src="settings?.website?.full_path">
                        </router-link>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 d-none d-lg-block">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li><router-link :to="{name: 'dashboard'}">Home </router-link></li>
                                <li><router-link :to="{name: 'products'}"> Shop</router-link></li>
                                <li v-for="c in settings?.category">
                                    <router-link :to="{name: 'productCategory', params: { slug: c.slug }}" :key="c.slug">
                                    {{ c.name }}</router-link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-6 col-8">
                    <div class="header-right-wrap">
                        <div class="same-style header-search">
                            <a class="search-active" href="#"><i class="pe-7s-search"></i></a>
                            <div class="search-content">
                                <form action="#">
                                    <input type="text" placeholder="Search">
                                    <button class="button-search"><i class="pe-7s-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="same-style account-satting" v-click-out-side="hideAccount">
                            <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i></a>
                            <div class="account-dropdown">
                                <ul>
                                    <li><a href="login-register.html">Login</a></li>
                                    <li><a href="login-register.html">Register</a></li>
                                    <li><a href="wishlist.html">Wishlist  </a></li>
                                    <li><a href="my-account.html">my account</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="same-style header-wishlist">
                            <a href="wishlist.html"><i class="pe-7s-like"></i></a>
                        </div>
                        <div class="same-style cart-wrap" v-click-out-side="hideCart">
                            <button class="icon-cart">
                                <i class="pe-7s-shopbag"></i>
                                <span class="count-style">02</span>
                            </button>
                            <div class="shopping-cart-content" >
                                <ul>
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt src="images/cart-1.png"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="#">T- Shart & Jeans </a></h4>
                                            <h6>Qty: 02</h6>
                                            <span>$260.00</span>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fa fa-times-circle"></i></a>
                                        </div>
                                    </li>
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt src="images/cart-2.png"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="#">T- Shart & Jeans </a></h4>
                                            <h6>Qty: 02</h6>
                                            <span>$260.00</span>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fa fa-times-circle"></i></a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-total">
                                    <h4>Shipping : <span>$20.00</span></h4>
                                    <h4>Total : <span class="shop-total">$260.00</span></h4>
                                </div>
                                <div class="shopping-cart-btn btn-hover text-center">
                                    <a class="default-btn" href="cart-page.html">view cart</a>
                                    <a class="default-btn" href="checkout.html">checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow">
                            <li><router-link :to="{name: 'dashboard'}">Home </router-link></li>
                            <li><router-link :to="{name: 'products'}"> Shop</router-link></li>
                            <li v-for="c in settings?.category"><router-link :to="{name: 'productCategory', params: { slug: c.slug }}">
                                {{ c.name }}</router-link></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import store from "../../Store/store";
import clickOutSide from "@mahdikhashan/vue3-click-outside";

export default {
    data: function () {
        return {}
    },
    directives: {
        clickOutSide,
    },
    computed: {
        auth: function () {
            return store.getters.GetAuth
        },
        settings: function () {
            return store.getters.GetWebsite
        }
    },
    methods: {
        hideCart: function () {
            $('.shopping-cart-content').removeClass('cart-visible');
        },
        hideAccount: function () {
            $('.account-dropdown').hide();
        },
        logout: function () {
            this.$store.dispatch('Logout')
        }
    },
}
</script>

<style lang="scss" scoped>
.logo{
    img{
        height: 30px;
        object-fit: cover;
        object-position: center;
    }
}
</style>
