import { mapActions, mapGetters } from "vuex";
export const taskMethods = mapActions(['createNewTask', 'getListCards', 'getListTasks', 'updateTask', 'getCurrentTask']);
export const authMethods = mapActions(['auth', 'logout']);