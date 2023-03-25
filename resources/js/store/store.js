import { createStore } from 'vuex';

import {myModule} from './modules/my-store-module';
import Roles from './modules/roles';
import Permissions from './modules/permissions';
import Auth from './modules/auth';
import Project from './modules/project';
import Task from './modules/task';

export const store = createStore({
    modules: {
        Roles,
        Permissions,
        Auth,
        myModule,
        Project,
        Task
    },
});