const state = {
    listProjects: [],
    projectData:{},
    loadingState: false,
    currentProject: {}
};

const getters = {
    listProjects: state => state.listProjects,
    projectData: state => state.projectData,
    currentProject: state => state.currentProject,
};
const actions = {  

    /**
     * get all project 
     * @param {*} param0 
     */
    async getProjects({ commit }) {
        commit('loadingState', true);
        let res = await axios.post('/api/project/index');
        if (res.status == 200) {
            commit('addItemProjects', res.data);
            commit('loadingState', false);
        }
    },

     /**
     * create project
     * @param {*} param0 
     */
    async createProject({commit}, data) {
        let res = await axios.post(`/api/project/create`, data);
        if (res.status == 200) {
            return res.data;
            // commit('addItemProjects', res.data);
        }
    },

    /**
     * remove or add user in project
     * @param {data} data => project id, user ud, action 
     */
    async addRemoveUserInProject({ commit }, data){
        let res = await axios.post(`/api/project/adduser`, data);
        return res.data;
    },

    /**
     * remove or add user in project
     * @param {data} data => project id, user ud, action 
     */
    async getProject( {commit}, slug ){
        commit('loadingState', true);
        var data = {'slug': slug}
        let res = await axios.post(`/api/project/show`, data);
        if (res.status == 200) {
            commit('setCurrentProject', res.data);
        }
    }
};

const mutations = {
    loadingState: (state, payload) => (state.loadingState = payload),
    addItemProjects: (state, payload) => (state.listProjects = payload),
    setCurrentProject: (state, payload) => (state.currentProject = payload),
};
export default {
    state,
    getters,
    actions,
    mutations
};