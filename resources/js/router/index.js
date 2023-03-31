import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../components/layouts/Dashboard.vue';
import Single from '../components/layouts/single-project.vue';
import Login from '../components/account/Login.vue';
import Register from '../components/account/Register.vue';
import Layout from '../components/layouts/Layout.vue';
// import htmldemo from "../components/layouts/htmldemo.vue";
import ViewProject from '../components/projects/ViewProject.vue'
export const routes = [
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
        path: '/viewproject/:id',
        name: 'viewproject',
        component: ViewProject
    },

    {
        name: 'single',
        path: '/single',
        component: Single,
    },
    // {
    //     path: '/htmldemo',
    //     name: 'htmldemo',
    //     component: htmldemo
    // },
];
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router

// router.beforeEach((to, from, next) => {
//     const isAuthenticated = sessionStorage.getItem('loginResponse')
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//         // if the route requires authentication and the user is not authenticated, redirect to login page
//         if (!isAuthenticated) {
//             next({
//                 path: '/login',
//                 query: { redirect: to.fullPath }
//             })
//         } else {
//             next()
//         }
//     } else {
//         next() // proceed to the next middleware
//     }
// })