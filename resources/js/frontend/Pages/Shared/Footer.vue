<template>
    <footer class="footer-area bg-gray pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <div class="copyright mb-30">
                        <div class="footer-logo">
                            <router-link :to="{name: 'dashboard'}">
                                <img style="width: 100px" v-if="settings?.website?.full_path" alt :src="settings?.website?.full_path">
                                <span v-else class="icon-name">{{settings?.website?.name}}</span>
                            </router-link>
                        </div>
                        <p>© {{ new Date().getFullYear() }} <router-link :to="{name: 'dashboard'}">Diivaa</router-link>.<br> All Rights Reserved</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <div class="footer-widget mb-30 ml-50">
                        <div class="footer-title">
                            <h3>USEFUL LINKS</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li v-for="p in settings?.pages"><router-link :to="{name: 'page', params: {slug: p.slug}}">{{ p.name }}</router-link></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 ml-75">
                        <div class="footer-title">
                            <h3>FOLLOW US</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li v-if="settings?.website?.social_facebook"><a :href="settings?.website.social_facebook">
                                    <i style="color: #1873EB" class="fa fa-facebook-official"></i> Facebook</a>
                                </li>
                                <li v-if="settings?.website?.social_twitter"><a :href="settings?.website?.social_twitter">
                                    <i style="color: #1D9BF0" class="fa fa-twitter"></i> Twitter</a>
                                </li>
                                <li v-if="settings?.website?.social_instagram"><a :href="settings?.website?.social_instagram">
                                    <i style="color: #F502BB" class="fa fa-instagram"></i> Instagram</a>
                                </li>
                                <li v-if="settings?.website?.social_youtube"><a :href="settings?.website?.social_youtube">
                                    <i style="color: #FE0000" class="fa fa-youtube"></i> Youtube</a>
                                </li>
                                <li v-if="settings?.website?.social_linkedIn"><a :href="settings?.website?.social_linkedIn">
                                    <i style="color: #0A66C2" class="fa fa-linkedin-square"></i> LinkedIn</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 ml-70">
                        <div class="footer-title">
                            <h3>ABOUT US</h3>
                        </div>
                        <div class="subscribe-style">
                            <p>{{ settings?.website?.about }}</p>
                            <p><span class="text-theme">Phone:</span> {{ settings?.website?.phone }}</p>
                            <p><span class="text-theme">Email:</span> {{ settings?.website?.email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</template>

<script>
import store from "../../Store/store";

export default {
    data: function () {
        return {}
    },
    computed: {
        settings: function () {
            return store.getters.GetWebsite
        }
    },
    methods: {

    },
}
</script>

<style scoped>
.icon-name{
    font-size: 35px;
    font-weight: bold;
}
</style>
