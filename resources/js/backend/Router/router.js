import { createWebHistory, createRouter } from 'vue-router'

import Login from "../Pages/Auth/Login.vue"
import Layout from "../Pages/Layout/Layout.vue"
import Dashboard from "../Pages/Dashboard/Dashborad.vue"
import Category from "../Pages/Settings/Category/Category.vue"
import DeliveryFee from "../Pages/Settings/DeliveryFee/DeliveryFee.vue"
import Slide from "../Pages/Settings/Slide/Slide.vue"
const routes = [
    {
        name: "login",
        path: "/secure-admin/login",
        component: Login,
        beforeEnter: authCheck,
    },
    {
        name: "layout",
        path: "/secure-admin",
        component: Layout,
        beforeEnter: authRequestCheck,
        children: [
            { path: "/", name: "dashboard", component: Dashboard},
            { path: "/secure-admin/category", name: "category", component: Category},
            { path: "/secure-admin/delivery/fee", name: "deliveryFee", component: DeliveryFee},
            { path: "/secure-admin/slide", name: "slide", component: Slide},
            { path: "/secure-admin/slide", name: "slide", component: Slide},
        ]
    }
]

function authCheck(to, from, next) {
    let token = localStorage.getItem('ecommerce_access_token');
    if (token !== undefined && token != null) {
        next('/secure-admin');
    } else {
        next();
    }
}
function authRequestCheck(to, from, next) {
    let token = localStorage.getItem('ecommerce_access_token');
    if (token === undefined || token == null) {
        next('/secure-admin/login');
    } else {
        next();
    }
}

const router = createRouter({
    history: createWebHistory(),
    routes,
})
export default router
