<template>
    <div>
        <Breadcrumb section-name="Order" :breadcrumb="breadCrumb"></Breadcrumb>
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <Table :tbl-data="table" :param="param"></Table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="status" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize">Update Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="updateStatus()">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Status<span class="text-danger">*</span></label>
                                <select v-model="statusParam.status" name="name"  class="form-control" >
                                    <option value="pending">Pending</option>
                                    <option value="cancel">Cancel</option>
                                    <option value="on the way">On the way</option>
                                    <option value="delivered">Delivered</option>
                                </select>
                                <small class="invalid-feedback text-danger"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary btn-width" v-if="!loading">
                                Update
                            </button>
                            <button type="button" class="btn btn-primary btn-width" v-if="loading">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="single" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize">View order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Variant</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
    </div>
</template>

<script>
import Breadcrumb from "../Common/Breadcrumb.vue";
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
import Table from "../Common/Table.vue";
import ConfirmDialogue from "../Common/confirmPopup/ConfirmDialogue.vue";

export default {
    components: {Table, Breadcrumb, ConfirmDialogue},
    data() {
        return {
            breadCrumb: ['List'],
            loading: false,
            statusParam: {
                order_id: '',
                status: '',
            },
            addEditParam: {},
            param: {
                keyword: '',
                limit: 10,
                order_by: 'id',
                order_mode: 'DESC',
                page: 1,
            },
            actionType: 'Add',
            id: [],
            table: {
                columns: [
                    {type: 'text', key: 'order_number', label: 'Order No', sortable: true},
                    {type: 'text', key: 'user_name', label: 'Customer Name', sortable: true},
                    {type: 'text', key: 'user_phone', label: 'Customer Phone', sortable: true},
                    {type: 'text', key: 'sub_total', label: 'Sub total', sortable: true},
                    {type: 'text', key: 'delivery_charge', label: 'Delivery Charge', sortable: true},
                    {type: 'text', key: 'total', label: 'Total', sortable: true},
                    {type: 'text', key: 'delivery_address', label: 'Delivery Address', sortable: true},
                    {type: 'text', key: 'status', label: 'Order Status', sortable: true, isCapital: true},
                ],
                rows: [],
                row_actions: [
                    {name: 'view', type: 'action', label: 'bx bx-search-alt', color: 'btn-info'},
                    {name: 'status', type: 'action', label: 'bx bx-repost', color: 'btn-gradient-info'},
                    {name: 'send', type: 'action', label: 'bx bx-navigation', color: 'btn-gradient-danger'}
                ],
                tableIconAction: (data) => {
                    this.openModal(data.row_action, data.row_data);
                },
                tableLoading: false,
                paginateData: {},
                updatePagination: (page) => {
                    this.list(page)
                },
                updateFilter: (param) => {
                    this.param = param
                    this.list()
                },
                dropdown: [
                    {
                        title: 'Select Status',
                        data: [
                            {id: 'pending', name: 'Pending'},
                            {id: 'cancel', name: 'Canceled'},
                            {id: 'on the way', name: 'On the way'},
                            {id: 'delivered', name: 'Delivered'},
                        ],
                        action: (event) => {
                            this.param.status = event.target.value
                            this.list()
                        }
                    }
                ],
                noDataError: ''
            },
            singleData: null
        }
    },
    methods: {
        openModal(type, data = null) {
            if (type === 'status') {
                this.statusParam.order_id = data.id
                this.statusParam.status = data.status
                $('#status').modal('show');
            }
            if (type === 'view') {
                this.single(data.id)
                $('#single').modal('show');
            }
        },
        updateStatus: function () {
            ApiService.ClearErrorHandler();
            this.loading = true;
            ApiService.POST(ApiRoutes.updateStatusOrder, this.statusParam, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.$toast.success(res.message)
                    $('#status').modal('hide');
                    this.list()
                } else {
                    ApiService.ErrorHandler(res.errors);
                }
            });
        },
        single: function (order_id) {
            ApiService.POST(ApiRoutes.singleOrder, {order_id: order_id}, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.singleData = res.data
                } else {
                    ApiService.ErrorHandler(res.errors);
                }
            });
        },
        edit: function () {
            ApiService.ClearErrorHandler();
            this.loading = true;
            ApiService.POST(ApiRoutes.EditCategory, this.addEditParam, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.$toast.success(res.message)
                    $('#add').modal('hide');
                    this.list()
                } else {
                    ApiService.ErrorHandler(res.errors);
                }
            });
        },
        list: function (page) {
            if (page == undefined) {
                page = 1
            }
            this.param.page = page;
            this.table.loading = true
            ApiService.POST(ApiRoutes.getOrder, this.param, (res) => {
                this.table.loading = false
                if (parseInt(res.status) === 200) {
                    res.data.data.forEach(v => {
                        if (v.user != null) {
                            v.user_name = v.user.name
                        }
                        if (v.guest != null) {
                            v.user_name = v.guest.name + '(Guest)'
                        }
                    })
                    this.table.rows = res.data.data
                    this.table.paginateData = res.data
                }
            });
        },
    },
    mounted() {
        this.list()
    },
    created() {

    }
}
</script>

<style scoped>

</style>
