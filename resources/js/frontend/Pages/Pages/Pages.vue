<template>
    <div class="breadcrumb-area pt-35 pb-35 bg-gray-3 mb-5">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <router-link :to="{name: 'dashboard'}">Home</router-link>
                    </li>
                    <li class="active"><a href="javascript:void(0)" class="active" v-if="singleData">{{singleData.name}}</a> </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-60" v-if="singleData">
            <div v-html="singleData.content"></div>
        </div>
    </div>
</template>

<script>
import ApiService from "../../Services/ApiService";
import ApiRoutes from "../../Services/ApiRoutes";
import store from "../../Store/store";
import Table from "../../../backend/Pages/Common/Table.vue";

export default {
    name: "order",
    components: {Table},
    watch:{
        $route (to, from){
            this.slug = this.$route.params.slug;
            this.single()
        }
    },
    data() {
        return {
            APP_URL: window.APP_URL,
            singleData: null,
            slug: null
        }
    },
    methods: {
        single: function () {
            ApiService.POST(ApiRoutes.GetPagesSingle, {slug: this.slug},(res) => {
                if (parseInt(res.status) === 200) {
                    this.singleData = res.data
                }
            });
        },
    },
    created() {
        this.slug = this.$route.params.slug;
        this.single()
    },
}
</script>
<style scoped lang="scss">
.order-status{
    width: 100%;
    padding: 10px 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #a749ff;
    transition: 500ms;
    border: 1px solid #a749ff;
    &.active{
        transition: 500ms;
        background-color: #a749ff;
        color: #ffffff;
    }
    &:hover{
        transition: 500ms;
        background-color: #a749ff;
        color: #ffffff;
    }
}
</style>
