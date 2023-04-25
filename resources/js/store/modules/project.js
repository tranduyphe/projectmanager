import moment from "moment";
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
        var config = "";
        if (data['file']) {
            let formData = new FormData();
            formData.append('file', data['file']);
            formData.append('end_time', moment(data['end_time']).format('YYYY-MM-DD HH:mm:ss'));
            formData.append('description',data['description']);
            formData.append('start_time', moment(data['start_time']).format('YYYY-MM-DD HH:mm:ss'));
            formData.append('title', data['title']);
            formData.append('type', 'projects');
            config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }
            let res = await axios.post(`/api/project/create`, formData, config);
            if (res.status == 200) {
                return res.data;
            }
        }else{
            let res = await axios.post(`/api/project/create`, data);
            if (res.status == 200) {
                return res.data;
            }
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
    },
    /**
     * update project
     * @param {data} 
     */
    async updateProject({commit}, data){
        var config = "";
        if (data['file']) {
            let formData = new FormData();
            formData.append('file', data['file']);
            formData.append('id', data['id']);
            formData.append('title', data['data']['title']);
            formData.append('description', data['data']['description']);
            formData.append('end_time', data['data']['end_time']);
            formData.append('start_time', data['data']['start_time']);
            // formData.append('data', data['data']);
            formData.append('type', 'projects');
            config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }
            let res = await axios.post(`/api/project/update`, formData, config);
            if (res.status == 200) {
                return res.data;
            }
        }else{
            let res = await axios.post(`/api/project/update`, data);
            if (res.status == 200) {
                return res.data;
            }
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