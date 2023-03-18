const state = {
    listProjects: "",
    testProject1: 'test',
    loadingState: false,
};

const getters = {
    listProjects: state => state.listProjects,
    testProject: state => state.testProject1,
};
const actions = {  

    getProjects({ commit }) {
        commit('loadingState', true);
        var demo = {
            project:4, 
            project_2:3
        };
        // commit('listProjects');
        //commit('loadingState', false);
        // this.listProject = 'list project demo';
        // return 'listProject';
        axios
        .post('/api/project/store')
        .then(response => {
            if (response.status == 200) {
                commit('listProjects', response.data);
                commit('loadingState', false);
            }
        })
        .catch(error => {
            console.log(error);
        });
    },
};

const mutations = {
    listProjects: (state, payload) => (state.listProjects = payload),
    loadingState: (state, payload) => (state.loadingState = payload),
};
export default {
    state,
    getters,
    actions,
    mutations
};