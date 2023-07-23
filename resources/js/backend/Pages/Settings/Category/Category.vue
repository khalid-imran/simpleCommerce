<template>
    <div>
        <Breadcrumb section-name="Settings" :breadcrumb="breadCrumb" :btn-name="'Add '+ breadCrumb"
                    :click-action="openModal"></Breadcrumb>
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <Table :tbl-data="table" :param="param"></Table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize">{{ actionType }} {{ 'Accounts Category' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="actionType == 'add' ? add() : edit()">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Categrty Name<span class="text-danger">*</span></label>
                                <input type="text" v-model="addEditParam.name" name="name"
                                       class="form-control" id="name" placeholder="Categrty Name">
                                <small class="invalid-feedback text-danger"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary btn-width" v-if="!loading">
                                {{ actionType == 'add' ? 'Save' : 'Update' }}
                            </button>
                            <button type="button" class="btn btn-primary btn-width" v-if="loading">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
    </div>
</template>

<script>
import Breadcrumb from "../../Common/Breadcrumb.vue";
import ApiService from "../../../Services/ApiService";
import ApiRoutes from "../../../Services/ApiRoutes";
import Table from "../../Common/Table.vue";
import ConfirmDialogue from "../../Common/confirmPopup/ConfirmDialogue.vue";
import DownloadService from "../../../Services/DownloadService";

export default {
    components: {Table, Breadcrumb, ConfirmDialogue},
    data() {
        return {
            breadCrumb: [],
            loading: false,
            addEditParam: {
                name: '',
            },
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
                    {type: 'text', key: 'name', label: 'Name', sortable: true},
                ],
                rows: [],
                row_actions: [
                    {name: 'edit', type: 'action', label: 'bx bx-pencil', color: 'btn-info'},
                    {name: 'delete', type: 'action', label: 'bx bx-trash', color: 'btn-gradient-danger'}
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
                noDataError: 'Please click "+ Add Accounts Category" Type to add a new Accounts Category'
            },
        }
    },
    methods: {
        openModal(type, data = null) {
            this.clearForm(type)
            this.id = this.structureReturnData(data)
            if (type === 'add' || type === 'edit') {
                $('#add').modal('show');
            }
            if (type === 'edit') {
                this.single()
            } else if (type === 'delete') {
                this.deleteModal()
            }
        },
        clearForm: function (type) {
            ApiService.ClearErrorHandler();
            this.actionType = type
            this.addEditParam = {
                name: '',
                type: this.type,
            }
        },
        async deleteModal() {
            const ok = await this.$refs.confirmDialogue.show({
                message: 'Are you sure you want to delete this Category?',
                okButton: 'Delete',
            })
            if (ok) {
                this.delete()
            }
        },
        add: function () {
            ApiService.ClearErrorHandler();
            this.loading = true;
            ApiService.POST(ApiRoutes.AddCategory, this.addEditParam, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    $('#add').modal('hide');
                    this.$toast.success(res.message)
                    this.list()
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
        delete: function () {
            ApiService.POST(ApiRoutes.DeleteCategory, {id: this.id[0]}, (res) => {
                this.$refs.confirmDialogue._loading(false)
                if (parseInt(res.status) === 200) {
                    this.$toast.success(res.message)
                    this.$refs.confirmDialogue._hide()
                    this.list()
                }
            });
        },
        single: function () {
            ApiService.POST(ApiRoutes.SingleCategory, {id: this.id[0]}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.addEditParam = res.data
                }
            });
        },
        list: function (page) {
            if (page == undefined) {
                page = 1
            }
            this.param.page = page;
            this.table.loading = true
            ApiService.POST(ApiRoutes.ListCategory, this.param, (res) => {
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
        this.breadCrumb.push('Accounts Category')
    }
}
</script>

<style scoped>

</style>
