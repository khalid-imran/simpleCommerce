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
                                        <h5 class="mb-0 text-primary">Add New Product</h5>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row form-group mb-3">
                                                <div class="col-sm-3">
                                                    <template v-if="!photo">
                                                        <input @change="addPhoto" id="fancy-file-upload" type="file"
                                                               name="files" accept=".jpg, .png, image/jpeg, image/png"
                                                               class="d-none">
                                                        <label for="fancy-file-upload" class="file-upload signature">Photo</label>
                                                    </template>
                                                    <template v-if="photo">
                                                        <div class="position-relative w-content">
                                                            <img class="signature" :src="photo" alt="">
                                                            <div class="remove-sig bg-danger" @click="removePhoto">
                                                                <i class="bx bx-trash"></i>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="name" class="form-label">Code<span class="text-danger">*</span></label>
                                                                <input type="text" v-model="addEditParam.code" name="code" class="form-control" id="code"
                                                                       placeholder="Code">
                                                                <small class="invalid-feedback text-danger"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                                                <input type="text" v-model="addEditParam.name" name="name" class="form-control" id="name"
                                                                       placeholder="Name">
                                                                <small class="invalid-feedback text-danger"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="name" class="form-label">Short Name</label>
                                                                <input type="text" v-model="addEditParam.short_name" name="short_name" class="form-control" id="short_name"
                                                                       placeholder="Short Name">
                                                                <small class="invalid-feedback text-danger"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="name" class="form-label">Color</label>
                                                                <input type="text" v-model="addEditParam.color" name="color" class="form-control" id="color"
                                                                       placeholder="Color">
                                                                <small class="invalid-feedback text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Weight</label>
                                                <input type="text" v-model="addEditParam.weight" name="weight" class="form-control" id="weight"
                                                       placeholder="Weight">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">DP</label>
                                                <input type="text" v-model="addEditParam.dp" name="dp" class="form-control" id="dp"
                                                       placeholder="DP">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">TP</label>
                                                <input type="text" v-model="addEditParam.tp" name="tp" class="form-control" id="tp"
                                                       placeholder="TP">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">MRP</label>
                                                <input type="text" v-model="addEditParam.mrp" name="mrp" class="form-control" id="mrp"
                                                       placeholder="MRP">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Box</label>
                                                <input type="text" v-model="addEditParam.box" name="box" class="form-control" id="box"
                                                       placeholder="Box">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Carton</label>
                                                <input type="text" v-model="addEditParam.carton" name="carton" class="form-control" id="carton"
                                                       placeholder="Carton">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Trade Offer</label>
                                                <input type="text" v-model="addEditParam.trade_offer" name="trade_offer" class="form-control" id="trade_offer"
                                                       placeholder="Trade Offer">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Free</label>
                                                <input type="text" v-model="addEditParam.free" name="free" class="form-control" id="free"
                                                       placeholder="Free">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">DP after Trade Offer</label>
                                                <input type="text" v-model="addEditParam.dp_after_trade_offer" name="dp_after_trade_offer" class="form-control" id="dp_after_trade_offer"
                                                       placeholder="DP after Trade Offer">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Materials</label>
                                                <input type="text" v-model="addEditParam.materials" name="materials" class="form-control" id="materials"
                                                       placeholder="Materials">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Benefits</label>
                                                <input type="text" v-model="addEditParam.benefits" name="benefits" class="form-control" id="benefits"
                                                       placeholder="Benefits">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Bsti(cm license)</label>
                                                <input type="text" v-model="addEditParam.cm_license" name="cm_license" class="form-control" id="cm_license"
                                                       placeholder="Bsti(cm license)">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Bsti (metrology license)</label>
                                                <input type="text" v-model="addEditParam.metrology_license" name="metrology_license" class="form-control" id="metrology_license"
                                                       placeholder="Bsti (metrology license)">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Remarks</label>
                                                <input type="text" v-model="addEditParam.remarks" name="remarks" class="form-control" id="remarks"
                                                       placeholder="Remarks">
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">How to use</label>
                                                <vue-editor v-model="addEditParam.usage" :editor-toolbar="customToolbar" name="usage"/>
                                                <small class="invalid-feedback text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <router-link :to="{name: 'product'}" type="button" class="btn btn-secondary me-2 btn-width" >Close</router-link>
                            <button type="submit" class="btn btn-primary btn-width me-2" v-if="!loading">
                                Save
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
            breadCrumb: ['Add'],
            loading: false,
            dataLoading: false,
            addEditParam: {
                image: '',
                code: '',
                name: '',
                short_name: '',
                color: '',
                weight: '',
                dp: '',
                tp: '',
                mrp: '',
                box: '',
                carton: '',
                trade_offer: '',
                free: '',
                dp_after_trade_offer: '',
                remarks: '',
                usage: '',
                benefits: '',
                cm_license: '',
                metrology_license: '',
                materials: '',
            },
            photo: null,
            customToolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],

                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],

                ['clean']
            ]
        }
    },
    methods: {
        addPhoto: function (e) {
            this.addEditParam.image = e.target.files[0];
            this.photo = URL.createObjectURL(this.addEditParam.image);
        },
        removePhoto: function () {
            this.addEditParam.image = '';
            this.photo = null;
        },
        manage: function (isNew = false) {
            ApiService.ClearErrorHandler();
            this.loading = true;
            let param = this.makeFormData(this.addEditParam)
            ApiService.POST(ApiRoutes.AddProduct, param, (res) => {
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
    },
    mounted () {

    },
    created() {

    }
}
</script>

<style scoped>

</style>
