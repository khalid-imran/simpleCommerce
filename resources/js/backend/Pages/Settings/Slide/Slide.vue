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
                        <h5 class="modal-title text-capitalize">{{ actionType }} {{ 'Slide' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="actionType == 'add' ? add() : edit()">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Title<span class="text-danger">*</span></label>
                                <input type="text" v-model="addEditParam.title" name="title"
                                       class="form-control" id="title" placeholder="Title">
                                <small class="invalid-feedback text-danger"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Button Title<span class="text-danger">*</span></label>
                                <input type="text" v-model="addEditParam.button_title" name="button_title"
                                       class="form-control" id="button_title" placeholder="Button Title">
                                <small class="invalid-feedback text-danger"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Slide Image<span class="text-danger">*</span></label>
                                <template v-if="!image">
                                    <input @change="addFile" id="fancy-sig-upload" type="file"
                                           name="file" accept=".jpg, .png, image/jpeg, image/png"
                                           class="d-none">
                                    <label for="fancy-sig-upload" class="file-upload signature"></label>
                                </template>
                                <template v-if="image">
                                    <div class="position-relative">
                                        <img class="signature" :src="image" alt="">
                                        <div class="remove-sig bg-danger" @click="removeFile">
                                            <i class="bx bx-trash"></i>
                                        </div>
                                    </div>
                                </template>
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
            image: null,
            addEditParam: {
                title: '',
                button_title: '',
                file: '',
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
                    {type: 'text', key: 'title', label: 'Title', sortable: true},
                    {type: 'text', key: 'button_title', label: 'Button Title', sortable: true},
                    {type: 'img', key: 'full_path', label: 'Image', sortable: true},
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
                noDataError: 'Please click "+ Add Slide" Type to add a new Slide'
            },
        }
    },
    methods: {
        addFile: function (e) {
            this.addEditParam.file = e.target.files[0];
            this.image = URL.createObjectURL(this.addEditParam.file);
        },
        removeFile: function () {
            this.addEditParam.file = '';
            this.image = null;
        },
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
                title: '',
                button_title: '',
                file: ''
            }
            this.image = null
        },
        async deleteModal() {
            const ok = await this.$refs.confirmDialogue.show({
                message: 'Are you sure you want to delete this Slide?',
                okButton: 'Delete',
            })
            if (ok) {
                this.delete()
            }
        },
        add: function () {
            ApiService.ClearErrorHandler();
            this.loading = true;
            let param = this.makeFormData(this.addEditParam)
            ApiService.POST(ApiRoutes.AddSlide, param, (res) => {
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
            let param = this.makeFormData(this.addEditParam)
            ApiService.POST(ApiRoutes.EditSlide, param, (res) => {
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
            ApiService.POST(ApiRoutes.DeleteSlide, {id: this.id[0]}, (res) => {
                this.$refs.confirmDialogue._loading(false)
                if (parseInt(res.status) === 200) {
                    this.$toast.success(res.message)
                    this.$refs.confirmDialogue._hide()
                    this.list()
                }
            });
        },
        single: function () {
            ApiService.POST(ApiRoutes.SingleSlide, {id: this.id[0]}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.addEditParam = res.data
                    this.image = this.addEditParam.full_path
                }
            });
        },
        list: function (page) {
            if (page == undefined) {
                page = 1
            }
            this.param.page = page;
            this.table.loading = true
            ApiService.POST(ApiRoutes.ListSlide, this.param, (res) => {
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
        this.breadCrumb.push('Slide')
    }
}
</script>

<style scoped>

</style>
