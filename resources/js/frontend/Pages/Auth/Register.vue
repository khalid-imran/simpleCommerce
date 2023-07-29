<template>
    <div class="login-register-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ms-auto me-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active">
                                <h4> register </h4>
                            </a>
                        </div>
                        <div class="login-form-container">
                            <div class="login-register-form">
                                <form action="#" method="post">
                                    <input type="text" name="user-name" placeholder="Username">
                                    <input type="password" name="user-password" placeholder="Password">
                                    <input name="user-email" placeholder="Email" type="email">
                                    <div class="button-box">
                                        <button type="submit"><span>Register</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
