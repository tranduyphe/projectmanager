const state = {
    listTasks: {}, // get all task of project
    listCard: {}, // get all cart
    currentTask: {}, // get current task of project
    listUsers: {}, // get list user of department
    listTaskDraggable: {}, // get list task add drag,
    listUserProject: {}, // get list user of project,
    loadingStatus: false,
};
const getters = {
    listTasks: state => state.listTasks,
    listCard: state => state.listCard,
    currentTask: state => state.currentTask,
    listUsers: state => state.listUsers,
    listTaskDraggable: state => state.listTaskDraggable,
    projectUsers: state => state.listUserProject,
    loadingStatus: state => state.loadingStatus,
};
const actions = {
    
    // get list cards
    async getListCards({commit}) {
        state.listCard = {}
        let res = await axios.post(`/api/card`);
        if (res.status == 200) {           
            commit('setCard', res.data.cards);
            commit('setListUsers', res.data.list_user);
        } 
    },

    // get all task
    async getListTasks({commit}, id) {        
        let res = await axios.post(`/api/tasks/index/${id}`) 
        if (res.status == 200) {
            commit('setTask', res.data.list_task); 
            commit('setTaskDraggable', res.data.list_draggable);
            if (res.data.project_users.length == 0) {
                commit('setListProjectUsers', {});
            } else{
                commit('setListProjectUsers', res.data.project_users);
            }
             
        }
    },

    // create new task task
    async createNewTask({ commit }, data){
        let res = await axios.post(`/api/tasks/create`, data); 
        if (res.status == 200 ) {
            return res.data;
        }
    },
    // update data task
    async updateTask({ commit }, data){
        if (!state.loadingStatus) {
            commit('loadingStatus', true);
            let res = await axios.post(`/api/tasks/update`, data);
            if (res.status == 200) { 
                commit('setCurrentTask', res.data);  
                commit('loadingStatus', false);           
            }
            return res.status;
        }        
    },

    // add new work to do
    async createWorkTodo({ commit }, data){
        let res = await axios.post(`/api/todo/create`, data);
        if (res.status == 200) { 
            return res.data;
        }
    },

    // remove work to do
    async removeWorkTodo({ commit }, id){
        let res = await axios.post(`/api/todo/remove/${id}`);
        return res.status;
    },

    // add check list
    async addCheckList({ commit }, data){
        let res = await axios.post(`/api/checklist/create`, data);
        if (res.status == 200) { 
            return res.data;
        }
    },
    // update check list
    async updatedChecklist({ commit }, data){
        let res = await axios.post(`/api/checklist/update/${data['id']}`, data);
        return res.status;
    },
    // remove check in work todo
    async removeCheckList({commit}, id){
        let res = await axios.post(`/api/checklist/remove/${id}`);
        return res.status;
    },

    // upload file 
    async uploadFile({commit}, data){
        var config = "";
        if (typeof data['url'] == 'undefined') {
            config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }
        }
        let res = await axios.post(`/api/tasks/store`, data, config);
        return res.data;
    },
    // remove File upload
    async removeFilesMedia({commit}, data){
        let res = await axios.post(`/api/media/remove/${data['media_id']}`, data);
    },
    //get data current tasks
    getCurrentTask({commit}, data) {
        commit('setCurrentTask', data);
    },
};
const mutations = {
    setCard(state, payload){
        state.listCard = payload;
    },
    setTask(state, payload){       
        state.listTasks = payload;
    },
    setTaskDraggable(state, payload){       
        state.listTaskDraggable = payload;
    },
    setCurrentTask(state, payload){       
        state.currentTask = payload;
    },
    setListUsers(state, payload){       
        state.listUsers = payload;
    },
    setListProjectUsers(state, payload){       
        state.listUserProject = payload;
    },
    loadingStatus: (state, payload) => (state.loadingStatus = payload),
};

export default {
    state,
    getters,
    actions,
    mutations,
};