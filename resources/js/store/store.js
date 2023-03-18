import { createStore } from 'vuex';

import {myModule} from './modules/my-store-module';
import Roles from './modules/roles';
import Permissions from './modules/permissions';
import Login from './modules/auth';
import Project from './modules/project';

export const store = createStore({
    modules: {
        Roles,
        Permissions,
        Login,
        myModule,
        Project
    },
});