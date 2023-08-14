<template>
    <footer class="footer-area bg-gray pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <div class="copyright mb-30">
                        <div class="footer-logo">
                            <router-link :to="{name: 'dashboard'}">
                                <img v-if="settings?.website?.full_path" alt :src="settings?.website?.full_path">
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
                                <li><a href="javascript:void(0)">Returns</a></li>
                                <li><a href="javascript:void(0)">Support Policy</a></li>
                                <li><a href="javascript:void(0)">Size guide</a></li>
                                <li><a href="javascript:void(0)">FAQs</a></li>
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
                                <li v-if="settings?.website?.social_facebook"><a :href="settings?.website.social_facebook">Facebook</a></li>
                                <li v-if="settings?.website?.social_twitter"><a :href="settings?.website?.social_twitter">Twitter</a></li>
                                <li v-if="settings?.website?.social_instagram"><a :href="settings?.website?.social_instagram">Instagram</a></li>
                                <li v-if="settings?.website?.social_youtube"><a :href="settings?.website?.social_youtube">Youtube</a></li>
                                <li v-if="settings?.website?.social_linkedIn"><a :href="settings?.website?.social_linkedIn">LinkedIn</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 ml-70">
                        <div class="footer-title">
                            <h3>About us</h3>
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
