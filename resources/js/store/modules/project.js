const state = {
    listProjects: [],
    projectData:{},
    loadingState: false,
    // testdemo : 'hahahaha',
};

const getters = {
    listProjects: state => state.listProjects,
    projectData: state => state.projectData,
    // testdemo: state => state.testdemo,
};
const actions = {  
    getProjects({ commit }) {
        state.listProjects = [];
        commit('loadingState', true);
        axios
        .post('/api/project/store')
        .then(response => {            
            if (response.status == 200) {
                for (const key in response.data) {
                    const project = response.data[key];
                    commit('addItemProjects', project);
                }
                commit('loadingState', false);
            }
        })
        .catch(error => {
            console.log(error);
        });
    },
    async createProject({commit}, data) {
        let res = await axios.post(`/api/project/create`, data);
        if (res.status == 200) {
            commit('addItemProjects', res.data);
        }
    },
    // add user in project
    async addRemoveUserInProject({ commit }, data){
        let res = await axios.post(`/api/project/adduser`, data);
        return res.data;
    }
};

const mutations = {
    addItemProjects: (state, payload) => (state.listProjects.push(payload)),
    loadingState: (state, payload) => (state.loadingState = payload),
};
export default {
    state,
    getters,
    actions,
    mutations
};