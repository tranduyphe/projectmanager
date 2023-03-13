import { createStore } from 'vuex';
// import router from '../router/index';
import { myModule } from './modules/my-store-module';
// console.log(router)
// export const store = createStore({
//     modules: {
//         myModule,
//         test: myModule
//     },
// });
// import Vue from 'vue';
// import Vuex from 'vuex';
import Roles from './Modules/roles';
import Permissions from './Modules/permissions';
import Login from './Modules/login';

// Vue.use(Vuex);

export const store = createStore({
    modules: {
        Roles,
        Permissions,
        Login,
        myModule
    },
});