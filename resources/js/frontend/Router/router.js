import { createWebHistory, createRouter } from 'vue-router'

import Layout from "../Pages/Layout/Layout.vue"
import Dashboard from "../Pages/Dashboard/Dashborad.vue"
import Product from "../Pages/Product/Product.vue";
import ProductCategory from "../Pages/Product/ProductCategory.vue";
import ProductSingle from "../Pages/Product/ProductSingle.vue";
import Checkout from "../Pages/Checkout/Checkout.vue";
const routes = [
    {
        name: "layout",
        path: "/",
        component: Layout,
        children: [
            { path: "/", name: "dashboard", component: Dashboard},
            { path: "/products", name: "products", component: Product},
            { path: "/products/category/:slug", name: "productCategory", component: ProductCategory},
            { path: "/product/:slug", name: "productSingle", component: ProductSingle},
            { path: "/checkout", name: "checkout", component: Checkout},
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
const router = createRouter({
    history: createWebHistory(),
    routes,
})
export default router
