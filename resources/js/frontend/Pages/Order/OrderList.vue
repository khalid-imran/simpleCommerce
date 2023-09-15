<template>
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3 mb-5">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <router-link :to="{name: 'dashboard'}">Home</router-link>
                    </li>
                    <li class="active"><a href="javascript:void(0)" class="active">My Order</a> </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-60 justify-content-end" >
            <div class="col-sm-3">
                <select class="form-select" v-model="param.status">
                    <option value="">All order</option>
                    <option value="pending">Pending</option>
                    <option value="on the way">On the way</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancel">Canceled</option>
                </select>
            </div>
            <div class="col-sm-12 mt-5 mb-2">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Order No</th>
                        <th>Sub total</th>
                        <th class="text-end">Delivery Charge</th>
                        <th class="text-end">Total</th>
                        <th>Order Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody v-if="orders.length > 0">
                    <tr v-for="o in orders"  class="cursor-pointer" >
                        <td>{{o.order_number}}</td>
                        <td>{{o.discunt_sub_total}}</td>
                        <td class="text-end">{{o.delivery_charge}}</td>
                        <td class="text-end">{{o.total}}</td>
                        <td class="text-capitalize">
                            <span class="btn btn-success btn-sm" v-if="o.status == 'delivered'">{{o.status}}</span>
                            <span class="btn btn-warning btn-sm" v-if="o.status == 'pending'">{{o.status}}</span>
                            <span class="btn btn-info btn-sm" v-if="o.status == 'on the way'">{{o.status}}</span>
                            <span class="btn btn-danger btn-sm" v-if="o.status == 'cancel'">{{o.status}}</span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-outline-info btn-sm me-2" @click="openSingle(o)">View</button>
                            <button class="btn btn-outline-danger btn-sm" @click="openCancel(o)" v-if="o.status == 'pending'">Cancel</button>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="12" class="text-center">No order found</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="single" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" v-if="singleData != null">{{singleData.order_number}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" v-if="singleData != null">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Variant</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="p in singleData.order_item">
                                <td><img style="height: 110px" v-if="p?.product?.images.length > 0" :src="p?.product?.images[0].full_path" alt=""></td>
                                <td>{{p.product.title}}</td>
                                <td>{{p?.product_variants?.title}}</td>
                                <td class="text-end">{{calculateProductPrice(p)}}</td>
                                <td class="text-end">{{p.quantity}}</td>
                                <td class="text-end">{{calculateProductPrice(p) * p.quantity}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cancel" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 550px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize">Cancel Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-danger">Are you sure you want to cancel this order?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">No
                        </button>
                        <button type="button" class="btn btn-danger btn-width" @click="cancelOrder()">Yes</button>
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
import Table from "../../../backend/Pages/Common/Table.vue";

export default {
    name: "order",
    components: {Table},
    data() {
        return {
            APP_URL: window.APP_URL,
            orders: [],
            param: {
                status: '',
            },
            cancelParam: {
                order_id: '',
            },
            singleData: null
        }
    },
    watch: {
        'param.status': function () {
            if (this.guest) {
                this.getOrderGuest()
            } else {
                this.getOrder()
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
        calculateProductPrice: function (product) {
            let price = parseInt(product.product_variants.price);
            let reduce_price = 0
            if(product?.product.discount_type == 1){
                let discountAmount = parseInt(price) / 100 * parseInt(product?.product.discount_amount)
                reduce_price = price - discountAmount;
            } else if (product?.product.discount_type == 0){
                reduce_price = parseInt(price) - parseInt(product?.product.discount_amount)
            } else {
                reduce_price = price
            }
            return reduce_price
        },
        openCancel: function (data) {
            this.cancelParam.order_id = data.id
            $('#cancel').modal('show');
        },
        cancelOrder: function () {
            ApiService.POST(ApiRoutes.OrderCancel, this.cancelParam,(res) => {
                if (parseInt(res.status) === 200) {
                    if (this.guest) {
                        this.getOrderGuest()
                    } else {
                        this.getOrder()
                    }
                    $('#cancel').modal('hide');
                }
            });
        },
        openSingle: function (data) {
            this.single(data.id)
            $('#single').modal('show');
        },
        single: function (order_id) {
            this.singleData = null
            ApiService.POST(ApiRoutes.getOrderSingle, {order_id: order_id},(res) => {
                if (parseInt(res.status) === 200) {
                    this.singleData = res.data
                }
            });
        },
        getOrder: function () {
            ApiService.POST(ApiRoutes.getOrder, this.param,(res) => {
                if (parseInt(res.status) === 200) {
                    this.orders = res.data
                }
            });
        },
        getOrderGuest: function () {
            this.param.guest_user_id = this.guest.uid
            ApiService.POST(ApiRoutes.getOrderGuest, this.param,(res) => {
                if (parseInt(res.status) === 200) {
                    this.orders = res.data
                }
            });
        },
    },
    created() {
        if (this.guest) {
            this.getOrderGuest()
        } else {
            this.getOrder()
        }
    }
}
</script>
<style scoped lang="scss">
.order-status{
    width: 100%;
    padding: 10px 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #a749ff;
    transition: 500ms;
    border: 1px solid #a749ff;
    &.active{
        transition: 500ms;
        background-color: #a749ff;
        color: #ffffff;
    }
    &:hover{
        transition: 500ms;
        background-color: #a749ff;
        color: #ffffff;
    }
}
</style>
