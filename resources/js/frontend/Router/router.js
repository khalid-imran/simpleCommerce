import { createWebHistory, createRouter } from 'vue-router'

import Login from "../Pages/Auth/Login.vue"
import Layout from "../Pages/Layout/Layout.vue"
import Dashboard from "../Pages/Dashboard/Dashborad.vue"
import Product from "../Pages/Product/Product.vue";
import ProductCategory from "../Pages/Product/ProductCategory.vue";
const routes = [
    {
        name: "layout",
        path: "/",
        component: Layout,
        children: [
            { path: "/", name: "dashboard", component: Dashboard},
            { path: "/login", name: "login", component: Login},
            { path: "/products", name: "products", component: Product},
            { path: "/products/category/:slug", name: "productCategory", component: ProductCategory},
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})
export default router
