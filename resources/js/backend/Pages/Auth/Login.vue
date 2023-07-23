<template>
    <div class="bg-login">
        <div class="wrapper">
            <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                        <div class="col mx-auto">
                            <div class="card rounded-4">
                                <div class="card-body">
                                    <div class="border p-4 rounded-4">
                                        <div class="text-center">
                                            <img :src="APP_URL + '/images/logo-icon.png'" width="70" alt="" />
                                            <h5 class="mt-3 mb-0">Hi, Administration</h5>
                                            <p class="mb-4">Please login before enter the page</p>
                                        </div>

                                        <div class="form-body">
                                            <form class="row g-3" @submit.prevent="login">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email" class="form-label">Username</label>
                                                        <input type="text" v-model="loginParam.phone" name="email" class="form-control rounded-5" id="phone" placeholder="Username">
                                                        <small class="invalid-feedback text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" v-model="loginParam.password" name="password" class="form-control rounded-5" id="password" placeholder="Enter Password">
                                                        <small class="invalid-feedback text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" v-model="loginParam.remember" type="checkbox" id="flexSwitchCheckChecked">
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <a href="javascript:void(0)">Forgot Password ?</a>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" v-if="!loading" class="btn btn-gradient-info rounded-5">Sign in</button>
                                                        <button v-if="loading" class="btn btn-gradient-info rounded-5" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
export default {
    name:"login",
    data(){
        return {
            APP_URL: window.APP_URL,
            loginParam: {
                phone: '',
                password: '',
                remember: '',
                is_admin: 1
            },
            loading: false
        }
    },
    methods:{
        login: function() {
            this.loading = true;
            ApiService.POST(ApiRoutes.Login, this.loginParam, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.$store.commit('PutAccessToken', res.access_token);
                    this.$store.commit('PutAuth', res.user);
                    window.location.reload();
                } else {
                    ApiService.ErrorHandler(res.errors);
                }
            });
        }
    }
}
</script>
