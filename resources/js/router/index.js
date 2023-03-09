import { createRouter, createWebHistory } from 'vue-router';
import Backend from '../components/backend/Backend.vue';
import Login from '../components/auth/Login.vue';
export const routes = [
    {
        name: 'home',
        path: '/',
        component: Backend,
        meta: { requiresAuth: true } // thêm meta để kiểm tra xem route này cần đăng nhập hay không
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    }
];
const router = createRouter({
    history: createWebHistory(),
    routes
})
// router.beforeEach((to, from, next) => {
//     console.log(to);
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//       if (!window.authenticated) {
//         next({
//             path: '/login',
//             //query: { redirect: to.fullPath }
//         });
//       } else {
//         next();
//       }
//     } else {
//       next();
//     }
// });
export default router