import { createWebHistory, createRouter } from 'vue-router'

import Login from "../Pages/Auth/Login.vue"
import Layout from "../Pages/Layout/Layout.vue"
import Dashboard from "../Pages/Dashboard/Dashborad.vue"
const routes = [
    {
        name: "layout",
        path: "/",
        component: Layout,
        children: [
            { path: "/", name: "dashboard", component: Dashboard},
            { path: "/login", name: "login", component: Login},
            { path: "/product/:category?", name: "product", component: Login},
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})
export default router
