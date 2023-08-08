<template>
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3 mb-5">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <router-link :to="{name: 'dashboard'}">Home</router-link>
                    </li>
                    <li class="active">{{ slug }} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-60" >
            <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6" v-for="l in categoryProducts">
                <div class="product-wrap mb-25">
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
                                <a title="Add To Cart" href="#"><i class="pe-7s-cart"></i> Add to cart</a>
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

export default {
    name: "category",
    data() {
        return {
            APP_URL: window.APP_URL,
            categoryProducts: [],
            slug: null
        }
    },
    watch: {
        '$route.params.slug': function (newVal, oldVal) {
            if (newVal) {
                this.slug = newVal
                this.getCategoryProduct()
            }
        }
    },
    methods: {
        getCategoryProduct: function () {
            ApiService.POST(ApiRoutes.ProductByCategory, {slug: this.slug},(res) => {
                if (parseInt(res.status) === 200) {
                    this.categoryProducts = res.data
                }
            });
        },
    },
    created() {
        this.slug = this.$route.params.slug;
        this.getCategoryProduct()
    }
}
</script>
