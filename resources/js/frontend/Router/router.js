import { createWebHistory, createRouter } from 'vue-router'

import Login from "../Pages/Auth/Login.vue"
import Layout from "../Pages/Layout/Layout.vue"
import Dashboard from "../Pages/Dashboard/Dashborad.vue"
const routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        beforeEnter: authCheck,
    },
    {
        name: "layout",
        path: "/",
        component: Layout,
        beforeEnter: authRequestCheck,
        children: [
            { path: "/", name: "dashboard", component: Dashboard},
        ]
    }
]

function authCheck(to, from, next) {
    let token = localStorage.getItem('ecommerce_user_access_token');
    if (token !== undefined && token != null) {
        next('/');
    } else {
        next();
    }
}
function authRequestCheck(to, from, next) {
    let token = localStorage.getItem('ecommerce_user_access_token');
    if (token === undefined || token == null) {
        next('/login');
    } else {
        next();
    }
}

const router = createRouter({
    history: createWebHistory(),
    routes,
})
export default router
