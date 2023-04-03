const state = {
    listTasks: {}, // get all task of project
    listCard: {}, // get all cart
    currentTask: {}, // get current task of project
    listUsers: {}, // get list user of department
    listTaskDraggable: {}, // get list user of department
};
const getters = {
    listTasks: state => state.listTasks,
    listCard: state => state.listCard,
    currentTask: state => state.currentTask,
    listUsers: state => state.listUsers,
    listTaskDraggable: state => state.listTaskDraggable,
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
        let res = await axios.post(`/api/tasks/update`, data);
        if (res.status == 200) { 
            commit('setCurrentTask', res.data);             
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

    //get data curent tasl
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
};

export default {
    state,
    getters,
    actions,
    mutations,
};