const state = {
    listProjects: [],
    projectData:{},
    loadingState: false,
};

const getters = {
    listProjects: state => state.listProjects,
    projectData: state => state.projectData,
};
const actions = {  
    async getProjects({ commit }) {
        commit('loadingState', true);
        let res = await axios.post('/api/project/store');
        if (res.status == 200) {
            commit('addItemProjects', res.data);
            commit('loadingState', false);
        }
    },
    async createProject({commit}, data) {
        let res = await axios.post(`/api/project/create`, data);
        if (res.status == 200) {
            return res.data;
            // commit('addItemProjects', res.data);
        }
    },
    // add user in project
    async addRemoveUserInProject({ commit }, data){
        let res = await axios.post(`/api/project/adduser`, data);
        return res.data;
    }
};

const mutations = {
    loadingState: (state, payload) => (state.loadingState = payload),
    addItemProjects: (state, payload) => (state.listProjects = payload),
};
export default {
    state,
    getters,
    actions,
    mutations
};