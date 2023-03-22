const state = {
    listTasks: {},
    listCard: {},  
};
const getters = {
    listTasks: state => state.listTasks,
    listCard: state => state.listCard,
};
const actions = {  
    async getListCards({commit}) {
        let res = await axios.post(`/api/card`);
        if (res.status == 200) {
            commit('setCard', res.data);
        } 
    },
    async getListTasks({commit}, id) {
        let res = await axios.post(`/api/tasks/${id}`) 
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
    }
};
const mutations = {
    setCard(state, payload){
        if (state.listCard.length > 0) {
            state.listCard.push(payload);
        }else{
            state.listCard = payload;
        }
    },
    setTask(state, payload){       
        state.listTasks = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};