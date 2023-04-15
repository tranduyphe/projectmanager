import { mapActions, mapGetters } from "vuex";
export const taskMethods = mapActions(['createNewTask', 'getListCards', 'getListTasks', 'updateTask', 'getCurrentTask', 'createWorkTodo', 'removeWorkTodo', 'addCheckList', 'removeCheckList', 'uploadFile', 'removeFilesMedia']);
export const taskGetters = mapGetters(['listUsers', 'currentTask', 'listTasks', 'listCard', 'listTaskDraggable', 'projectUsers']);
export const authMethods = mapActions(['auth', 'logout', 'department']);
export const authGetters = mapGetters(['authUserData', 'departmentId']);
export const labelMethods = mapActions(['getLabels']);
export const labelGetters = mapGetters(['listItemLabels']);
export const projectMethods = mapActions(['addRemoveUserInProject', 'getProjects', 'createProject', 'getProject']);
export const projectGetters = mapGetters(['listProjects', 'projectData', 'currentProject']);