import Router from '../../router';

const state = {
    loginResponse: {},
    authUser: {},
    authUserData : {}
};

const getters = {
    getLoginResponse: state => state.loginResponse,
    getAuthUser: state => state.authUser,
    authUserData: state => state.authUserData,
};

const actions = {
    login({ commit, getters }, loginData) {
        axios.get('/sanctum/csrf-cookie').then(() => {
            axios
                .post('/api/login', {
                    email: loginData.email,
                    password: loginData.password,
                })
                .then(response => {
                    commit('mutateLoginResponse', response.data);
                    sessionStorage.setItem(
                        'loginResponse',
                        JSON.stringify(response.data)
                    );
                    if (getters.getLoginResponse.response_type == 'success') {
                        axios.get('/api/user').then(response => {
                            if (response.status == 200) {
                                commit('mutateAuthUser', response.data);                                
                                sessionStorage.setItem(
                                    'authUser',
                                    JSON.stringify(response.data)
                                );
                                Router.push('/dashboard');
                            }
                        });
                    }
                });
        });
    },

    auth({ commit }) {
        commit('mutateAuthUserData', JSON.parse(sessionStorage.getItem('authUser')));
    },

    logout() {        
        document.getElementById("preloader").style.display = "block";
        document.getElementById("status").style.display = "block";
        axios.get('/api/logout').then((response) => {
            sessionStorage.removeItem('loginResponse');
            sessionStorage.removeItem('authUser');
            Router.push('/');
            setTimeout(() => {
                window.location.reload('/')
            }, 100);
            
        });
    },
};

const mutations = {
    mutateLoginResponse: (state, payload) => (state.loginResponse = payload),
    mutateAuthUser: (state, payload) => (state.authUser = payload),
    mutateAuthUserData: (state, payload) => (state.authUserData = payload),
};

export default {
    state,
    getters,
    actions,
    mutations,
};
