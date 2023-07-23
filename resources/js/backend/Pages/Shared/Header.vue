<template>
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand">
                <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                </div>
                <div class="search-bar flex-grow-1">

                </div>
                <div class="top-menu ms-auto">

                </div>
                <div class="user-box dropdown">
                    <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/images/avatars/user.svg" class="user-img" alt="user avatar">
                        <div class="user-info ps-3">
                            <p class="user-name mb-0">{{auth.name}}</p>
                            <p class="designattion mb-0">{{ auth.email }}</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-user"></i><span>Profile</span></a>
                        </li>
                        <li>
                            <div class="dropdown-divider mb-0"></div>
                        </li>
                        <li @click="logout">
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class='bx bx-log-out-circle'></i><span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

</template>

<script>
import store from "../../Store/store";

export default {
    computed: {
        auth: function () {
            return store.getters.GetAuth
        }
    },
    methods: {
        logout: function () {
            this.$store.dispatch('Logout')
        }
    }
}
</script>

<style scoped>

</style>
