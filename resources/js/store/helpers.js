import { mapActions, mapGetters } from "vuex";
export const taskMethods = mapActions(['createNewTask', 'getListCards', 'getListTasks', 'updateTask', 'getCurrentTask', 'createWorkTodo', 'removeWorkTodo', 'addCheckList', 'removeCheckList', 'uploadFile', 'removeFilesMedia']);
export const taskGetters = mapGetters(['listUsers', 'currentTask', 'listTasks', 'listCard', 'listTaskDraggable']);
export const authMethods = mapActions(['auth', 'logout']);
export const authGetters = mapGetters(['authUserData']);
export const labelMethods = mapActions(['getLabels']);
export const labelGetters = mapGetters(['listItemLabels']);