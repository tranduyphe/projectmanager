import { createRouter, createWebHistory } from 'vue-router';
import Admin from '../components/backend/Admin.vue';
// import Dashboard from '../components/dashboard/Dashboard.vue';
import Login from '../components/account/Login.vue';
import Register from '../components/account/Register.vue';
// import Login from '../../views/pages/account/login.vue';
export const routes = [
    {
        name: 'home',
        path: '/',
        component: Admin,
        meta: { requiresAuth: true } // thêm meta để kiểm tra xem route này cần đăng nhập hay không
    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin,
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    }
];
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router