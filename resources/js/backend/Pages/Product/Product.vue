<template>
    <div>
        <Breadcrumb section-name="Product" :breadcrumb="breadCrumb" :btn-name="'Add '+ breadCrumb"
                    :click-action="addProduct"></Breadcrumb>
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <Table :tbl-data="table" :param="param"></Table>
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
import DownloadService from "../../Services/DownloadService";

export default {
    components: {Table, Breadcrumb, ConfirmDialogue},
    data() {
        return {
            breadCrumb: ['Product'],
            loading: false,
            param: {
                keyword: '',
                limit: 15,
                order_by: 'id',
                order_mode: 'DESC',
                page: 1,
            },
            id: [],
            table: {
                alignTop: false,
                columns: [
                    {type: 'text', key: 'title', label: 'Title', sortable: true},
                    {type: 'imgArr', key: 'images', label: 'Image', sortable: true},
                ],
                rows: [],
                row_actions: [
                    {name: 'edit', type: 'action', label: 'bx bx-pencil', color: 'btn-info'},
                    {name: 'delete', type: 'action', label: 'bx bx-trash', color: 'btn-gradient-danger'}
                ],
                tableIconAction: (data) => {
                    this.tableIconAction(data.row_action, data.row_data, data.row_index);
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
                noDataError: ' Please click "+ Add Product" to add a new Product'
            },
            department: [],
            designation: []
        }
    },
    methods: {
        async tableIconAction (type, data, index = null) {
            this.id = this.structureReturnData(data)
            if (type === 'edit') {
                this.$router.push({
                    name: 'productEdit',
                    params: { id: data.id }
                })
            } else if (type === 'view') {
                this.$router.push({
                    name: 'productView',
                    params: { id: data.id }
                })
            } else if (type === 'delete') {
                const ok = await this.$refs.confirmDialogue.show({
                    title: 'Delete Product',
                    message: 'Are you sure you want to delete this Product?',
                    okButton: 'Delete',
                })
                if (ok) {
                    this.delete()
                }
            }
        },
        addProduct() {
            this.$router.push({
                name: 'productAdd'
            })
        },
        async deleteModal() {
            const ok = await this.$refs.confirmDialogue.show({
                message: 'Are you sure you want to delete this Product?',
                okButton: 'Delete',
            })
            if (ok) {
                this.delete()
            }
        },
        delete: function () {
            ApiService.POST(ApiRoutes.DeleteProduct, {id: this.id[0]}, (res) => {
                this.$refs.confirmDialogue._loading(false)
                if (parseInt(res.status) === 200) {
                    this.$toast.success(res.message)
                    this.$refs.confirmDialogue._hide()
                    this.list()
                }
            });
        },

        list: function (page) {
            if (page == undefined) {
                page = 1
            }
            this.param.page = page;
            this.table.loading = true
            ApiService.POST(ApiRoutes.ListProduct, this.param, (res) => {
                this.table.loading = false
                if (parseInt(res.status) === 200) {
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
