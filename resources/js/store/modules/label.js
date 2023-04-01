const state = {
    listItemLabels: {}, // get all task of project
};
const getters = {
    listItemLabels: state => state.listItemLabels,
};
const actions = {  
    async getLabels({commit}, id) {        
        let res = await axios.post(`/api/labels`) 
        if (res.status == 200) {
            commit('setLabels', res.data); 
        }
    },
};
const mutations = {
    setLabels(state, payload){
        state.listItemLabels = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};