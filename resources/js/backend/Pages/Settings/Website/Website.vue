<template>
    <div>
        <Breadcrumb section-name="Settings" :breadcrumb="breadCrumb"></Breadcrumb>
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body" :class="{'data-loading': dataLoading}">
                   <div class="row">
                       <div class="col-sm-12">
                           <form @submit.prevent="manage">
                               <div class="fixed-card-height">
                                   <div class="card border-top border-0 border-4 border-primary">
                                       <div class="card-body p-4">
                                           <div class="card-title d-flex align-items-center">
                                               <h5 class="mb-0 text-primary">Website Settings</h5>
                                           </div>
                                           <hr>
                                           <div class="row">
                                               <div class="col-sm-3 mb-4">
                                                   <template v-if="!photo">
                                                       <input @change="addLogo" id="fancy-sig-upload" type="file"
                                                              name="files" accept=".jpg, .png, image/jpeg, image/png"
                                                              class="d-none">
                                                       <label for="fancy-sig-upload" class="file-upload signature">
                                                           Logo
                                                       </label>
                                                   </template>
                                                   <template v-if="photo">
                                                       <div class="position-relative">
                                                           <img class="signature" :src="photo" alt="">
                                                           <div class="remove-sig bg-danger" @click="removeLogo">
                                                               <i class="bx bx-trash"></i>
                                                           </div>
                                                       </div>
                                                   </template>
                                               </div>
                                               <div class="col-sm-9"></div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Name</label>
                                                   <input type="text" class="form-control" name="name" v-model="addEditParam.name">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">About</label>
                                                   <input type="text" class="form-control" name="about" v-model="addEditParam.about">
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Address</label>
                                                   <input type="text" class="form-control" name="address" v-model="addEditParam.address">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Phone</label>
                                                   <input type="text" class="form-control" name="phone" v-model="addEditParam.phone">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Email</label>
                                                   <input type="text" class="form-control" name="email" v-model="addEditParam.email">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Facebook Link</label>
                                                   <input type="text" class="form-control" name="social_facebook" v-model="addEditParam.social_facebook">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Linkedin Link</label>
                                                   <input type="text" class="form-control" name="email" v-model="addEditParam.social_linkedIn">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Youtube Link</label>
                                                   <input type="text" class="form-control" name="email" v-model="addEditParam.social_youtube">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Instagram Link</label>
                                                   <input type="text" class="form-control" name="email" v-model="addEditParam.social_instagram">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>
                                               <div class="col-sm-6 mb-3 form-group">
                                                   <label class="form-label">Twitter Link</label>
                                                   <input type="text" class="form-control" name="email" v-model="addEditParam.social_twitter">
                                                   <small class="invalid-feedback text-danger"></small>
                                               </div>

                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="text-end">
                                   <button type="submit" class="btn btn-primary btn-width" v-if="!loading">
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
        </div>
    </div>
</template>

<script>
import Breadcrumb from "../../Common/Breadcrumb";
import ApiService from "../../../Services/ApiService";
import ApiRoutes from "../../../Services/ApiRoutes";
import app from "../../../App.vue";
export default {
    computed: {
        app() {
            return app
        }
    },
    components: {Breadcrumb},
    data() {
        return {
            breadCrumb: ['Website'],
            loading: false,
            dataLoading: false,
            addEditParam: {
                name: '',
                logo: '',
                about: '',
                address: '',
                phone: '',
                email: '',
                social_facebook: '',
                social_linkedIn: '',
                social_youtube: '',
                social_instagram: '',
                social_twitter: '',
            },
            photo: null
        }
    },
    methods: {
        addLogo: function (e) {
            this.addEditParam.logo = e.target.files[0];
            this.photo = URL.createObjectURL(this.addEditParam.logo);
        },
        removeLogo: function () {
            this.addEditParam.logo = '';
            this.photo = null;
        },
        getSingle: function () {
            this.dataLoading = true
            ApiService.POST(ApiRoutes.SingleWebsite, null,(res) => {
                this.dataLoading = false
                if (parseInt(res.status) === 200) {
                    if (res.data != null) {
                        this.addEditParam = res.data
                        if (this.addEditParam.logo != null) {
                            this.photo = this.addEditParam.full_path
                        }
                    }
                }
            });
        },
        adfs: function () {
            this.dataLoading = true
            ApiService.POST(ApiRoutes.web, null,(res) => {
                /*this.dataLoading = false
                if (parseInt(res.status) === 200) {
                    if (res.data != null) {
                        this.addEditParam = res.data
                        if (this.addEditParam.logo != null) {
                            this.photo = this.addEditParam.full_path
                        }
                    }
                }*/
            });
        },
        manage: function () {
            ApiService.ClearErrorHandler();
            this.loading = true;
            let url = this.addEditParam.id != undefined && this.addEditParam.id != '' ? ApiRoutes.EditWebsite : ApiRoutes.AddWebsite;
            let param = this.makeFormData(this.addEditParam)
            ApiService.POST(url, param, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.$toast.success(res.message)
                } else {
                    ApiService.ErrorHandler(res.errors);
                }
            });
        },
    },
    mounted () {
    },
    created() {
        // this.getSingle()
        this.adfs()
    }
}
</script>

<style scoped>

</style>
