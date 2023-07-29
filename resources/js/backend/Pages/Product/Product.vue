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
                    {type: 'text', key: 'code', label: 'Product Code', sortable: true},
                    {type: 'text', key: 'name', label: 'Name', sortable: true, photo: true},
                    {type: 'text', key: 'short_name', label: 'Short Name', sortable: true},
                    {type: 'text', key: 'color', label: 'Color', sortable: true},
                    {type: 'text', key: 'weight', label: 'Weight', sortable: true},
                    {type: 'text', key: 'dp', label: 'DP', sortable: true},
                    {type: 'text', key: 'tp', label: 'TP', sortable: true},
                    {type: 'text', key: 'mrp', label: 'MRP', sortable: true},
                    {type: 'text', key: 'box', label: 'Box', sortable: true},
                    {type: 'text', key: 'carton', label: 'Carton', sortable: true},
                    {type: 'text', key: 'trade_offer', label: 'Trade Offer', sortable: true},
                    {type: 'text', key: 'free', label: 'Free', sortable: true},
                ],
                rows: [],
                row_actions: [
                    {name: 'view', type: 'action', label: 'bx bx-search-alt', color: 'btn-gradient-primary'},
                    {name: 'pdf', type: 'action', label: 'bx bx-file', color: 'btn-gradient-info',  loading: false},
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
                download: [
                    {
                        icon: 'xls',
                        loading: false,
                        action: () => {
                            this.downloadFile('xls')
                        }
                    },
                    {
                        icon: 'pdf',
                        loading: false,
                        action: () => {
                            this.downloadFile('pdf')
                        }
                    }
                ],
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
            } else if (type == 'pdf') {
                if (index != null) {
                    $('.' + index).toggle()
                    ApiService.DOWNLOAD(ApiRoutes.ProductSingleExportPdf, {id: data.id}, '', res => {
                        $('.' + index).toggle()
                        let blob = new Blob([res], {type: type});
                        const link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = data.name + '.pdf';
                        link.click();
                    });
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
        downloadFile: function (type) {
            let route = type === 'xls' ? ApiRoutes.ProductExportExcel : ApiRoutes.ProductExportPdf
            let name = type === 'xls' ? 'Product List.xlsx' : 'Product List.pdf'
            DownloadService.download(route, this.table.download, name, type, this.param)
        }
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
