<template>
    <div class="wrapper">
        <Header/>
        <router-view></router-view>
        <Footer/>
    </div>
</template>

<script>
import Header from "../Shared/Header.vue";
import Footer from "../Shared/Footer.vue";
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
export default {
    components: {Header, Footer},
    methods: {
        getWebsite: function () {
            ApiService.POST(ApiRoutes.Website, null,(res) => {
                this.dataLoading = false
                if (parseInt(res.status) === 200) {
                    this.$store.commit('PutWebsite', res.data);
                }
            });
        },
    },
    created() {
        this.getWebsite()
    },
    mounted() {

    }
}
</script>

<style lang="scss">

</style>
