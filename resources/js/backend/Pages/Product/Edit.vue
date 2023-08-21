<template>
    <div>
        <Breadcrumb section-name="Product" :breadcrumb="breadCrumb"></Breadcrumb>
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body" :class="{'data-loading': dataLoading}">
                    <form @submit.prevent="manage">
                        <div class="fixed-card-height">
                            <div class="card border-top border-0 border-4 border-primary mb-0">
                                <div class="card-body p-4">
                                    <div class="card-title d-flex align-items-center">
                                        <h5 class="mb-0 text-primary">Edit Product</h5>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Title<span class="text-danger">*</span></label>
                                                <input type="text" v-model="addEditParam.title" name="title" class="form-control" id="title"
                                                       placeholder="Title">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Category</label>
                                                <select name="category_id" class="form-control" v-model="addEditParam.category_id">
                                                    <option v-for="c in category" :value="c.id">{{c.name}}</option>
                                                </select>
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Discount Type</label>
                                                <select  v-model="addEditParam.discount_type" name="discount_type" class="form-control" id="discount_type">
                                                    <option value="2">None</option>
                                                    <option value="1">Percentage</option>
                                                    <option value="0">Fixed</option>
                                                </select>
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Discount Amount</label>
                                                <input type="text" :disabled="addEditParam.discount_type > 1" v-model="addEditParam.discount_amount"
                                                       name="discount_amount" class="form-control" id="discount_amount"
                                                       placeholder="Discount Amount">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Product Feature</label>
                                                <vue-editor v-model="addEditParam.features" :editor-toolbar="customToolbar" name="features"/>
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Product Description</label>
                                                <vue-editor v-model="addEditParam.description" :editor-toolbar="customToolbar" name="description"/>
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Buy Price</label>
                                                <input type="text" v-model="addEditParam.buy_price"
                                                       name="buy_price" class="form-control" id="buy_price"
                                                       placeholder="Buy Price">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label d-flex align-items-center justify-content-between">
                                                    <span>Product Variant</span>
                                                    <button type="button" class="btn btn-sm btn-inverse-primary" @click="addNewVariant">Add new variant</button>
                                                </label>
                                                <table class="table table-bordered align-items-center">
                                                    <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Price</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(v, i) in addEditParam.variants">
                                                        <td>
                                                            <input class="form-control" type="text" v-model="v.title">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" v-model="v.price">
                                                        </td>
                                                        <td class="text-center">
                                                            <i v-if="i > 0" class="bx bx-trash text-danger cursor-pointer fs-5" @click="removeVariant(i)"></i>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <input type="hidden" name="variants">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="each-video mb-5" v-if="addEditParam.video != null">
                                            <video controls :src="video"></video>
                                            <button type="button" class="btn btn-danger btn-radius me-2 delete-btn" v-if="addEditParam.video_path == null"
                                                    @click="addEditParam.video = null; video = null">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-radius me-2 delete-btn" v-if="addEditParam.video_path != null"
                                                    @click="removeVideoServer">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                        <div class="each-video mb-5" v-if="addEditParam.video == null">
                                            <input @change="addVideo" id="fancy-video-upload" type="file"
                                                   name="files" accept=".mp4, .wmv, .avi, .3gp"
                                                   class="d-none">
                                            <label for="fancy-video-upload" class="file-upload signature">Video</label>
                                        </div>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <template v-for="(img, index) in addEditParam.images">
                                                <div class="each-img me-4"  v-if="img?.full_path">
                                                    <img :src="img.full_path" alt="">
                                                    <button type="button" class="btn btn-danger btn-radius me-2 delete-btn" @click="removePhotoServer(img, index)">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </template>

                                            <div class="each-img me-4" v-for="(img, index) in images">
                                                <img :src="img" alt="">
                                                <button type="button" class="btn btn-danger btn-radius me-2 delete-btn" @click="removePhoto(index)">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                            <div class="each-img">
                                                <input @change="addPhoto" id="fancy-file-upload" type="file"
                                                       name="files" accept=".jpg, .png, image/jpeg, image/png"
                                                       class="d-none">
                                                <label for="fancy-file-upload" class="file-upload signature">Photo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <router-link :to="{name: 'product'}" type="button" class="btn btn-secondary me-2 btn-width" >Close</router-link>
                            <button type="submit" class="btn btn-primary btn-width me-2" v-if="!loading">
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
    </div>
</template>

<script>
import Breadcrumb from "../Common/Breadcrumb";
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
export default {
    components: {Breadcrumb},
    data() {
        return {
            breadCrumb: ['Edit'],
            loading: false,
            dataLoading: false,
            addEditParam: {},
            images: [],
            id: null,
            customToolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],

                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],

                ['clean']
            ],
            video: null
        }
    },
    methods: {
        addNewVariant: function () {
            this.addEditParam.variants.push({title: '', price: ''})
        },
        removeVariant: function (index) {
            this.addEditParam.variants.splice(index, 1)
        },
        addPhoto: function (e) {
            this.addEditParam.images.push(e.target.files[0]);
            this.images.push(URL.createObjectURL(e.target.files[0]));
        },
        removePhoto: function (index) {
            this.addEditParam.images.splice(index, 1)
            this.images.splice(index, 1)
        },
        removePhotoServer: function (img, index) {
            this.addEditParam.images.splice(index, 1)
            ApiService.POST(ApiRoutes.DeleteProductImage, {id: img.id}, (res) => {});
        },
        removeVideoServer: function () {
            this.addEditParam.video = null
            this.video = null
            ApiService.POST(ApiRoutes.DeleteProductVideo, {id: this.addEditParam.id}, (res) => {});
        },
        addVideo: function (e) {
            this.addEditParam.video = e.target.files[0];
            this.video = URL.createObjectURL(e.target.files[0]);
        },
        getCategory: function () {
            ApiService.POST(ApiRoutes.ListCategory, {limit: 20}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.category = res.data.data
                }
            });
        },
        manage: function () {
            ApiService.ClearErrorHandler();
            this.loading = true;
            let param = this.makeFormData(this.addEditParam)
            ApiService.POST(ApiRoutes.EditProduct, param, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.$router.push({
                        name: 'product'
                    })
                } else {
                    ApiService.ErrorHandler(res.errors);
                }
            });
        },
        single: function () {
            ApiService.POST(ApiRoutes.SingleProduct, {id: this.id}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.addEditParam = res.data
                    if (this.addEditParam.video) {
                        this.video = this.addEditParam.video_path
                    }
                }
            });
        },
    },
    mounted () {

    },
    created() {
        this.id = this.$route.params.id;
        this.getCategory()
        this.single()
    }
}
</script>

<style lang="scss" scoped>
.each-img{
    width: 175px;
    position: relative;
    img{
        width: 100%;
        height: 150px;
    }
    .delete-btn{
        position: absolute;
        top: -13px;
        right: -18px;
    }
}
.each-video{
    width: 350px;
    position: relative;
    video{
        width: 100%;
        height: 300px;
    }
    .delete-btn{
        position: absolute;
        top: -13px;
        right: -18px;
    }
}
</style>
