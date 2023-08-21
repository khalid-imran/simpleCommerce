<template>
    <div class="shop-area pt-100 pb-100">
        <div class="container">
            <div class="row mb-3"  v-if="singleProduct">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details">
                        <div class="product-details-img mb-5">
                            <div class="tab-content jump">
                                <div v-if="singleProduct.images.length > 0" v-for="(img,i) in singleProduct.images"
                                     :id="'shop-details-'+i" class="tab-pane large-img-style" :class="{active: i == 0}">
                                    <img :src="img.full_path" alt="">
                                    <span class="dec-price" v-if="singleProduct.discount_type == 1">-{{ singleProduct.discount_amount }}%</span>
                                    <div class="img-popup-wrap">
                                        <a class="img-popup" :href="img.full_path"><i
                                            class="pe-7s-expand1"></i></a>
                                    </div>
                                </div>
                                <div v-else  class="tab-pane large-img-style active" id="shop-details">
                                    <img src="/images/product_default.jpg" alt="">
                                    <span class="dec-price" v-if="singleProduct.discount_type == 1">-{{ singleProduct.discount_amount }}%</span>
                                    <div class="img-popup-wrap">
                                        <a class="img-popup" href="images/product_default.jpg"><i
                                            class="pe-7s-expand1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-details-tab nav">
                                <a :class="{active: i == 0}" class="shop-details-overly" v-if="singleProduct.images.length > 0"
                                   v-for="(img,i) in singleProduct.images"
                                   :href="'#shop-details-'+i" data-bs-toggle="tab">
                                    <img :src="img.full_path" alt="">
                                </a>
                                <a  class="shop-details-overly active" v-else
                                   href="#shop-details" data-bs-toggle="tab">
                                    <img src="/images/product_default.jpg" alt="">
                                </a>
                            </div>
                        </div>
                        <video id="video" v-if="singleProduct?.video_path" autoplay controls playsinline controlslist="nodownload" style="width: 100%;">
                            <source :src="singleProduct.video_path"/>
                        </video>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-content ml-70">
                        <h2>{{ singleProduct.title }}</h2>
                        <div class="product-details-price">
                            <span>৳ {{getPrice(singleProduct).reduce_price}} </span>
                            <span class="old" v-if="singleProduct.discount_type != 2">৳ {{ getPrice(singleProduct).price }}</span>
                        </div>
<!--                        <div class="pro-details-rating-wrap">-->
<!--                            <div class="pro-details-rating">-->
<!--                                <i class="fa fa-star-o yellow"></i>-->
<!--                                <i class="fa fa-star-o yellow"></i>-->
<!--                                <i class="fa fa-star-o yellow"></i>-->
<!--                                <i class="fa fa-star-o"></i>-->
<!--                                <i class="fa fa-star-o"></i>-->
<!--                            </div>-->
<!--                            <span><a href="#">3 Reviews</a></span>-->
<!--                        </div>-->
                        <p v-html="singleProduct.description"></p>
                        <div class="pro-details-list" v-html="singleProduct.features"></div>
                        <div class="pro-details-size-color">
                            <div class="pro-details-size">
                                <span>Variants</span>
                                <div class="pro-details-size-content">
                                    <ul>
                                        <template v-for="v in singleProduct.variants">
                                            <li @click="cart.variant_id = v.id" v-if="v.title != null">
                                                <a :class="{active: v.id == cart.variant_id }" href="javascript:void(0)">{{ v.title }}</a>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pro-details-quality">
                            <div class="cart-plus-minus">
                                <div class="dec qtybutton" @click="updateInputValue('decrease')">-</div>
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" v-model="cart.quantity">
                                <div class="inc qtybutton" @click="updateInputValue('increase')">+</div>
                            </div>
                            <div class="pro-details-cart btn-hover" @click="addToCart">
                                <a href="javascript:void(0)">Add To Cart  <i v-if="loading" class="fa fa-spin fa-spinner"></i></a>
                            </div>
                            <div class="pro-details-wishlist">
                                <a href="#"><i class="fa fa-heart-o"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="description-review-area pb-90">
        <div class="container">
            <div class="description-review-wrapper">
                <div id="des-details3" class="tab-pane">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="review-wrapper">
                                <div class="single-review">
                                    <div class="review-img">
                                        <img src="assets/img/testimonial/1.jpg" alt="">
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap">
                                            <div class="review-left">
                                                <div class="review-name">
                                                    <h4>White Lewis</h4>
                                                </div>
                                                <div class="review-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="review-left">
                                                <a href="#">Reply</a>
                                            </div>
                                        </div>
                                        <div class="review-bottom">
                                            <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere
                                                cubilia Curae Suspendisse viverra ed viverra. Mauris ullarper
                                                euismod vehicula. Phasellus quam nisi, congue id nulla.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-review child-review">
                                    <div class="review-img">
                                        <img src="assets/img/testimonial/2.jpg" alt="">
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap">
                                            <div class="review-left">
                                                <div class="review-name">
                                                    <h4>White Lewis</h4>
                                                </div>
                                                <div class="review-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="review-left">
                                                <a href="#">Reply</a>
                                            </div>
                                        </div>
                                        <div class="review-bottom">
                                            <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere
                                                cubilia Curae Sus pen disse viverra ed viverra. Mauris ullarper
                                                euismod vehicula. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="ratting-form-wrapper pl-50">
                                <h3>Add a Review</h3>
                                <div class="ratting-form">
                                    <form action="#">
                                        <div class="star-box">
                                            <span>Your rating:</span>
                                            <div class="ratting-star">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="rating-form-style mb-10">
                                                    <input placeholder="Name" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="rating-form-style mb-10">
                                                    <input placeholder="Email" type="email">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="rating-form-style form-submit">
                                                    <textarea name="Your Review" placeholder="Message"></textarea>
                                                    <input type="submit" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
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
            singleProduct: null,
            loading: false,
            slug: '',
            cart: {
                quantity: 1,
                variant_id: '',
                product_id: ''
            }
        }
    },
    computed: {
        auth: function () {
            return store.getters.GetAuthUser
        },
        guest: function () {
            return store.getters.GetGuest
        }
    },
    methods: {
        addToCart: function () {
            if (this.auth == null && this.guest == null) {
                this.createGuest()
            } else {
                this.cartRequestToServer()
            }
        },
        createGuest: function () {
            ApiService.POST(ApiRoutes.CreateGuest, null,(res) => {
                if (parseInt(res.status) === 200) {
                    this.$store.commit('PutGuest', res.guest);
                    this.cartRequestToServer()
                }
            });
        },
        cartRequestToServer: function () {
            this.loading = true
            if (this.guest) {
                this.cart.guest_user_id = this.guest.uid
            }
            ApiService.POST(ApiRoutes.AddCart, this.cart,(res) => {
                this.loading = false
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
        updateInputValue: function (type) {
            if (type == 'decrease') {
                if (this.cart.quantity != 0) {
                    this.cart.quantity--
                }
            } else {
                this.cart.quantity++
            }
        },
        getProduct: function () {
            ApiService.POST(ApiRoutes.ProductSingle, {slug: this.slug},(res) => {
                if (parseInt(res.status) === 200) {
                    this.singleProduct = res.data
                    this.cart.product_id = this.singleProduct.id
                    this.cart.variant_id = this.singleProduct.variants[0].id
                    setTimeout(() => {
                        $('.img-popup').magnificPopup({
                            type: 'image',
                            gallery: {
                                enabled: true
                            }
                        });
                    }, 1000)
                }
            });
        }
    },
    created() {
        this.slug = this.$route.params.slug
        this.getProduct()
    },
}
</script>
