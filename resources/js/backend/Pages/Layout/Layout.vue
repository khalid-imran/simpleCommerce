<template>
    <div class="wrapper">
        <Header/>
        <SideNav/>
        <div class="page-wrapper">
            <div class="page-content">
                <router-view></router-view>
            </div>
        </div>

    </div>
</template>

<script>
import Header from "../Shared/Header.vue";
import SideNav from "../Shared/Sidenav.vue";
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
export default {
    components: {Header, SideNav},
    mounted() {
        setTimeout(() => {
            $("#menu").metisMenu()
        }, 500)
    }
}
</script>

<style lang="scss">
.btn-width{
    min-width: 120px;
}
.min-height{
    min-height: 81vh;
}
.fixed-card-height{
    height: 78vh;
    overflow-y: auto;
    overflow-x: hidden;
}
.btn-radius{
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff!important;
    i{
        margin: 0;
        font-size: 14px;
    }
}
.v-toast__item--success {
    background-color: #098dfd !important;
}
.data-loading{
    filter: blur(2px);
}
</style>
