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
export default {
    components: {Header, Footer},
    mounted() {

    }
}
</script>

<style lang="scss">

</style>
