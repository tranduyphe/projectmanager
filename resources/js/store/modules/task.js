const state = {
    listTasks: {},
    listCard: {}, 
    currentTask: {},
    listUsers: {}, 
};
const getters = {
    listTasks: state => state.listTasks,
    listCard: state => state.listCard,
    currentTask: state => state.currentTask,
    listUsers: state => state.listUsers,
};
const actions = {  
    async getListCards({commit}) {
        state.listCard = {}
        let res = await axios.post(`/api/card`);
        if (res.status == 200) {           
            commit('setCard', res.data.cards);
            commit('setListUsers', res.data.list_user);
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