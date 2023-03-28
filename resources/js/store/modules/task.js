const state = {
    listTasks: {},
    listCard: {}, 
    currentTask: {} 
};
const getters = {
    listTasks: state => state.listTasks,
    listCard: state => state.listCard,
    currentTask: state => state.currentTask,
};
const actions = {  
    async getListCards({commit}) {
        state.listCard = {}
        let res = await axios.post(`/api/card`);
        if (res.status == 200) {
            commit('setCard', res.data);
        } 
    },
    async getListTasks({commit}, id) {
        
        let res = await axios.post(`/api/tasks/index/${id}`) 
        if (res.status == 200) {
            commit('setTask', res.data); 
        }
    },
    async createNewTask({ commit }, data){
        let res = await axios.post(`/api/tasks/create`, data); 
        // commit('setTask', res.data); 
    },
    async updateTask({ commit }, data){
        let res = await axios.post(`/api/tasks/update`, data);
        if (res.status == 200) {
            commit('setCurrentTask', res.data); 
        }
    },
    async getCurrentTask({commit}, id) {
        let res = await axios.post(`/api/tasks/show/${id}`);
        if (res.status == 200) {
            commit('setCurrentTask', res.data); 
        }
    },
};
const mutations = {
    setCard(state, payload){
        state.listCard = payload;
    },
    setTask(state, payload){       
        state.listTasks = payload;
    },
    setCurrentTask(state, payload){       
        state.currentTask = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};