import { createWebHistory, createRouter } from 'vue-router'

import Login from "../Pages/Auth/Login.vue"
import Layout from "../Pages/Layout/Layout.vue"
import Dashboard from "../Pages/Dashboard/Dashborad.vue"
import Category from "../Pages/Settings/Category/Category.vue"
import DeliveryFee from "../Pages/Settings/DeliveryFee/DeliveryFee.vue"
import Slide from "../Pages/Settings/Slide/Slide.vue"
import Website from "../Pages/Settings/Website/Website.vue"
import Product from "../Pages/Product/Product.vue"
import ProductAdd from "../Pages/Product/Add.vue"
import ProductEdit from "../Pages/Product/Edit.vue"
import Order from "../Pages/Order/Order.vue";
import Pages from "../Pages/Settings/Pages/Pages.vue";
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
            { path: "/secure-admin", name: "dashboard", component: Dashboard},
            { path: "/secure-admin/category", name: "category", component: Category},
            { path: "/secure-admin/delivery/fee", name: "deliveryFee", component: DeliveryFee},
            { path: "/secure-admin/slide", name: "slide", component: Slide},
            { path: "/secure-admin/website", name: "website", component: Website},
            { path: "/secure-admin/product", name: "product", component: Product},
            { path: "/secure-admin/product/add", name: "productAdd", component: ProductAdd},
            { path: "/secure-admin/product/edit/:id", name: "productEdit", component: ProductEdit},
            { path: "/secure-admin/order", name: "order", component: Order},
            { path: "/secure-admin/pages", name: "pages", component: Pages},
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
