<template>
    <div>
        <div class="breadcrumb-area pt-20 pb-20 bg-gray-3 mb-5">
            <div class="container">
                <h1 class="text-center">
                    <router-link class="text-decoration-none" :to="{name: 'dashboard'}" href="">
                        <img v-if="settings?.website?.full_path" alt :src="settings?.website?.full_path" style="height: 70px">
                        <span v-else>Diivaa</span>
                    </router-link>
                </h1>
            </div>
        </div>
        <div class="checkout-area pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="billing-info-wrap">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="billing-info mb-20 form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" v-model="orderParam.name" name="name">
                                        <small class="invalid-feedback text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="billing-info mb-20 form-group">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input type="text" v-model="orderParam.phone" name="phone">
                                        <small class="invalid-feedback text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="billing-info mb-20 form-group">
                                        <label>District <span class="text-danger">*</span></label>
                                        <v-select class="form-control" :options="state" label="name" name="state_id" v-model="orderParam.state_id"
                                                  :reduce="(option) => option.id"></v-select>
                                        <small class="invalid-feedback text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="billing-info mb-20 form-group">
                                        <label>City <span class="text-danger">*</span></label>
                                        <v-select class="form-control" :options="city" label="name"  name="city_id" v-model="orderParam.city_id"
                                                  :reduce="(option) => option.id"></v-select>
                                        <small class="invalid-feedback text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="billing-info mb-20 form-group">
                                        <label>Full Address <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Write you full address includes Thana, Upazila and zila" v-model="orderParam.address" name="address">
                                        <small style="font-size: 11px">Example: house # 65, road #9/a, Mirpur 13, Dhaka - 1216</small>
                                        <small class="invalid-feedback text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="your-order-area">
                            <h3>Your order</h3>
                            <div class="your-order-wrap gray-bg-4">
                                <div class="your-order-product-info">
                                    <div class="your-order-top">
                                        <ul>
                                            <li>Product</li>
                                            <li>Total</li>
                                        </ul>
                                    </div>
                                    <div class="your-order-middle">
                                        <ul>
                                            <li class="align-items-center position-relative" v-for="c in cartData">
                                                <span class="order-middle-left">
                                                    <img v-if="c.images.length > 0" class="p-img" :src="c.images[0].full_path" alt="">
                                                    <img v-else class="p-img" src="/images/product_default.jpg" alt="">
                                                    <span class="me-3"> <span class="product-name" v-tooltip="c.title">{{ c.title }}</span>  <span class="d-inline-block">X</span>  <span class="d-inline-block">{{ c.cart_quantity }}</span></span>
                                                    <span class="varient-title" v-if="c.variant_title"  v-tooltip="c.variant_title">{{c.variant_title}}</span>
                                                </span>
                                                <span class="order-price">৳ {{c.price}}.00 </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-bottom">
                                        <ul>
                                            <li class="your-order-shipping">Shipping</li>
                                            <li>
                                                ৳ {{orderParam.delivery_charge}}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-total">
                                        <ul>
                                            <li class="order-total">Total</li>
                                            <li>৳ {{totalPrice}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="Place-order mt-25">
                                <a class="btn-hover" @click="makeOrder" v-if="!orderLoading" href="javascript:void(0)">Place Order</a>
                                <a class="btn-hover" v-if="orderLoading" href="javascript:void(0)">Placing Order...</a>
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
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";

export default {
    data: function () {
        return {
            orderParam: {
                delivery_charge: 0,
                name: '',
                address: '',
                phone: '',
                state_id: '',
                city_id: ''
            },
            totalPrice: 0,
            orderLoading: false,
            city: [],
            state: [],
        }
    },
    watch: {
        'orderParam.state_id': function () {
            this.getCity()
        },
        'orderParam.city_id': function () {
            this.city.map(v => {
                if (v.id == this.orderParam.city_id) {
                    this.orderParam.delivery_charge = v.cost
                }
            })
            this.updateTotalPrice()
        }
    },
    computed: {
        cartData: function () {
            return store.getters.GetCartData
        },
        auth: function () {
            return store.getters.GetAuthUser
        },
        guest: function () {
            return store.getters.GetGuest
        },
        settings: function () {
            return store.getters.GetWebsite
        },
    },
    methods: {
        updateTotalPrice: function () {
            this.totalPrice = 0
            this.cartData.map(v => {
                this.totalPrice += parseInt(v.price)
            })
            this.totalPrice += parseInt(this.orderParam.delivery_charge)
        },
        hideCart: function () {
            $('.shopping-cart-content').removeClass('cart-visible');
        },
        makeOrder: function () {
            if (this.orderLoading) {
                return;
            }
            ApiService.ClearErrorHandler();
            this.orderLoading = true
            if (this.guest != null) {
                this.orderParam.guest_user_id = this.guest?.uid
            }
            ApiService.POST(ApiRoutes.addOrder, this.orderParam,(res) => {
                this.orderLoading = false
                if (parseInt(res.status) === 200) {
                    if (this.auth != null) {
                        this.getUserDetail()
                    } else {
                        this.getGuestDetail()
                    }
                }else {
                    ApiService.ErrorHandler(res.errors);
                }
            });
        },
        getGuestDetail() {
            ApiService.POST(ApiRoutes.GetGuest, {id: this.guest.id},(res) => {
                this.orderLoading = false
                if (parseInt(res.status) === 200) {
                    this.$store.commit('PutGuest', res.guest);
                    this.$router.push({
                        name: 'complete'
                    })
                }
            });
        },
        getUserDetail() {
            ApiService.POST(ApiRoutes.Profile, {},(res) => {
                this.orderLoading = false
                if (parseInt(res.status) === 200) {
                    this.$store.commit('PutAuth', res.user);
                    this.$router.push({
                        name: 'complete'
                    })
                }
            });
        },
        getState: function () {
            ApiService.POST(ApiRoutes.GetState, {}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.state = res.data
                }
            });
        },
        getCity: function () {
            ApiService.POST(ApiRoutes.GetCity, {state_id: this.orderParam.state_id}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.city = res.data
                }
            });
        },
    },
    mounted() {
        this.hideCart()
        this.getState()
        this.getCity()
        if (this.guest) {
            if (this.guest.name != null) {
                this.orderParam.name = this.guest.name
            }
            if (this.guest.phone != null) {
                this.orderParam.phone = this.guest.phone
            }
            if (this.guest.address != null) {
                this.orderParam.address = this.guest.address
            }
        }
        if (this.auth) {
            if (this.auth.name != null) {
                this.orderParam.name = this.auth.name
            }
            if (this.auth.phone != null) {
                this.orderParam.phone = this.auth.phone
            }
            if (this.auth.address != null) {
                this.orderParam.address = this.auth.address
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.p-img{
    height: 100px;
    width: 100px;
    object-position: center;
    object-fit: contain;
    margin-right: 15px;
    @media only screen and (max-width: 440px) {
        height: 80px;
        width: 75px;
    }
}
.varient-title {
    padding: 0px 10px;
    border: 1px solid #a749ff;
    color: #a749ff;
    font-size: 12px !important;
    margin-left: auto;
    position: absolute;
    left: 7.2rem;
    line-height: 18px;
    max-width: 130px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    bottom: 0.5rem;
}
.product-name{
    width: 130px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: inline-block;
    position: relative;
    top: 8px;
    @media only screen and (max-width: 440px) {
        width: 90px;
    }
    @media only screen and (max-width: 350px) {
        width: 44px;
    }
}
.order-price{
    width: 80px;
    text-align: right;
}
</style>



