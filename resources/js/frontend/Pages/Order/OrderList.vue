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
        <div class="row mb-60" >
            <div class="col-sm-3">
                <div class="order-status" :class="{'active': param.status == 'pending'}" @click="param.status = 'pending'">
                    Pending
                </div>
            </div>
            <div class="col-sm-3">
                <div class="order-status" :class="{'active': param.status == 'on the way'}" @click="param.status = 'on the way'">
                    On the way
                </div>
            </div>
            <div class="col-sm-3">
                <div class="order-status" :class="{'active': param.status == 'delivered'}" @click="param.status = 'delivered'">
                    Delivered
                </div>
            </div>
            <div class="col-sm-3">
                <div class="order-status" :class="{'active': param.status == 'cancel'}" @click="param.status = 'cancel'">
                    Canceled
                </div>
            </div>
            <div class="col-sm-12 mt-5 mb-2">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Order No</th>
                        <th>Sub total</th>
                        <th>Delivery Charge</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody v-if="orders.length > 0">
                    <tr v-for="o in orders"  class="cursor-pointer" >
                        <td>{{o.order_number}}</td>
                        <td>{{o.sub_total}}</td>
                        <td>{{o.delivery_charge}}</td>
                        <td>{{o.total}}</td>
                        <td class="text-capitalize">{{o.status}}</td>
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
    </div>
</template>

<script>
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
import store from "../../Store/store";

export default {
    name: "order",
    data() {
        return {
            APP_URL: window.APP_URL,
            orders: [],
            param: {
                status: 'pending',
            }
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
