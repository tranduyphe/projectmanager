import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../components/layouts/Dashboard.vue';
import Single from '../components/layouts/single-project.vue';
import Login from '../components/account/Login.vue';
import ViewProject from '../components/projects/ViewProject.vue'
export const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    },
    // {
    //     name: 'dashboard',
    //     path: '/',
    //     component: Dashboard,
    //     meta: { requiresAuth: true }
    // },
    {
        path: '/viewproject/:id',
        name: 'viewproject',
        component: ViewProject,
        meta: { requiresAuth: true }
    },

    {
        name: 'single',
        path: '/single',
        component: Single,
        meta: { requiresAuth: true }
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes
})

// router.beforeEach((to, from, next) => {   
//     console.log('name', to.name)
//     console.log('isAuthenticated', isAuthenticated())
//     if (isAuthenticated() || to.name === 'login') {
//         next()
//     } else {
//         // Not logged in, redirect to login.
//         next({name: 'login'})
//     }
// });
  
// function isAuthenticated() {
//     // Check if the user is authenticated
//     let output = undefined;

//     if (sessionStorage.getItem('loginResponse')) {
//         output = true;
//     }else{
//         output = false
//     }
//     return output;
// }

export default router