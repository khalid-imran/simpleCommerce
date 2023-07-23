<template>
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <h4 class="logo-text">Diivaa</h4>
            </div>
            <div class="toggle-icon ms-auto" @click="isToggled = !isToggled"><i class='bx' :class="toggleClass()"></i></div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <router-link :to="{name: 'dashboard'}">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </router-link>
            </li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-cog"></i>
                    </div>
                    <div class="menu-title">Settings</div>
                </a>
                <ul>
                    <li :class="isActive('category')">
                        <router-link :to="{name: 'category'}"><i class="bx bx-right-arrow-alt"></i>Category</router-link>
                    </li>
                    <li :class="isActive('deliveryFee')">
                        <router-link :to="{name: 'deliveryFee'}"><i class="bx bx-right-arrow-alt"></i>Delivery Fee</router-link>
                    </li>
                    <li :class="isActive('slide')">
                        <router-link :to="{name: 'slide'}"><i class="bx bx-right-arrow-alt"></i>Slide</router-link>
                    </li>
                </ul>
            </li>
        </ul>
        <!--end navigation-->
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            isToggled: false,
        }
    },
    methods: {
        toggleClass: function () {
            if (this.isToggled) {
                return 'bx-arrow-to-right'
            } else {
                return 'bx-arrow-to-left'
            }
        },
        isActive: function (routeName) {
            if (this.$route.name == routeName) {
                return 'mm-active'
            } else {
                return ''
            }
        }
    },
}
</script>

<style scoped>

</style>
