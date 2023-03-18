import { createRouter, createWebHistory } from 'vue-router';
import Admin from '../components/backend/Admin.vue';
import Dashboard from '../components/layouts/Dashboard.vue';
import Login from '../components/account/Login.vue';
import Register from '../components/account/Register.vue';
import Layout from '../components/layouts/Layout.vue';
export const routes = [
    // {
    //     name: 'home',
    //     path: '/',
    //     component: Admin,
    //     meta: { requiresAuth: true } // thêm meta để kiểm tra xem route này cần đăng nhập hay không
    // },
    {
        name: 'login',
        path: '/',
        component: Login,
        meta: { requiresAuth: false } // thêm meta để kiểm tra xem route này cần đăng nhập hay không
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard,
    },
    {
        name: 'layouthtml',
        path: '/layouthtml',
        component: Layout,
    },
    // {
    //     path: '/register',
    //     name: 'register',
    //     component: Register
    // }
];
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router