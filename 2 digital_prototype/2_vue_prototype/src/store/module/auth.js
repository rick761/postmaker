import Vue from 'vue';
import Vuex from 'vuex';
import user from '../models/user'
import router from '../../router/index';
const root = { root: true };


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden

    state: () => ({
        token: localStorage.getItem('user-token'),
    }),

    mutations: {
        SET_TOKEN(state, token) {
            state.token = token;
        },
    },
    actions: {
        login({ dispatch, rootState, commit }, payload) {
            dispatch('request/post', { url: 'api/login', data: payload }, root).then(() => {
                var result = rootState.request.RESPONSE;
                console.log(result);
                if (result.access_token) {
                    localStorage.setItem('user-token', result.access_token);
                    commit('SET_TOKEN', result.access_token);
                    dispatch('request/get', 'api/user', root).then(() => {
                        dispatch('user/set', rootState.request.RESPONSE);
                    });
                    router.push('/home')
                }
            });
        },

        register({ commit, dispatch, rootState }, payload) {
            dispatch('request/get', 'api/user', root).then(() => {
                var isLoggedIn = rootState.request.RESPONSE.id != undefined;
                if (isLoggedIn) {
                    dispatch('logout').then(() => {
                        dispatch('request/post', { url: 'api/register', data: payload }, root).then(() => {
                            var result = rootState.request.RESPONSE;
                            console.log(result);
                            if (result.access_token) {
                                localStorage.setItem('user-token', result.access_token)
                                commit('SET_TOKEN', result.access_token);
                                dispatch('request/get', 'api/user', root).then(() => {
                                    dispatch('user/set', rootState.request.RESPONSE);
                                });
                                router.push('/home')
                            }
                        });
                    })
                }
                if (!isLoggedIn) {
                    dispatch('request/post', { url: 'api/register', data: payload }, root).then(() => {
                        var result = rootState.request.RESPONSE;
                        if (result.access_token) {
                            localStorage.setItem('user-token', result.access_token)
                            commit('SET_TOKEN', result.access_token);
                            dispatch('request/get', 'api/user', root).then(() => {
                                dispatch('user/set', rootState.request.RESPONSE);
                            });
                            router.push('/home')
                        }
                    });
                }
            });
        },

        // log uit
        logout({ rootState, dispatch }) {
            dispatch('request/get', 'api/logout', root).then(() => {
                var success = rootState.request.RESPONSE;
                if (success) {
                    dispatch('user/clear');
                }
            });
        },

        //getauth on load
        get({ dispatch, rootState }) {
            dispatch('request/get', 'api/user', root).then(() => {
                var user = rootState.request.RESPONSE;
                var isLoggedIn = rootState.request.RESPONSE.id != undefined;
                if (isLoggedIn) {
                    dispatch('user/set', user);
                }
            });
        },

        //redirect if user login
        checkAuth({ dispatch, rootState }) {
            dispatch('request/get', 'api/user', root).then(() => {
                var isLoggedIn = Object.keys(rootState.request.RESPONSE).length
                if (isLoggedIn) {
                    router.push('/home');
                }
            });
        },

        async editAuth({ commit, dispatch }, payload) {
            commit('loader/SET_2_ON', null, root);
            dispatch('user/set', payload);
            console.log(payload);
            dispatch('request/post', { url: 'api/updateUser', data: payload }, root).then(() => {
                commit('loader/SET_2_OFF', null, root);
            });
        }

    },
    modules: {
        user,
    },
};