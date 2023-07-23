<template>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ sectionName }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>
                    <li v-for="b in breadcrumb" class="breadcrumb-item active" aria-current="page">{{b}}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto" v-if="btnName" @click="btnAction()">
            <button type="button" class="btn btn-primary">
                <i class="animated bx bx-plus"></i>
                {{btnName}}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['sectionName', 'breadcrumb', 'btnName', 'clickAction'],
    name: "Breadcrumb",
    data() {
        return {

        }
    },
    methods: {
        btnAction: function () {
            if (this.clickAction) {
                this.clickAction('add', null)
            }

        }
    }

}
</script>

<style scoped>
.breadcrumb-item{
    text-transform: capitalize;
}
button{
    text-transform: capitalize;
}
</style>
