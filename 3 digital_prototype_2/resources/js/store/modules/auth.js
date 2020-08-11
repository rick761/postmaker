import Vue from 'vue';
import Vuex from 'vuex';
import { SET_AUTH, UPDATE_AUTH } from '../mutation-types';
import { ROOT } from '../constants'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        user: {

        }
    }),
    mutations: {
        [SET_AUTH](state, payload) {
            state.user = payload
        },
        [UPDATE_AUTH](state, payload) {
            for (var i in payload) {
                state.user[i] = payload[i];
            }
        }
    },
    actions: {
        async get({ commit, dispatch, rootState }) {
            await dispatch('api/get', '/auth', ROOT).then(() => {
                commit(SET_AUTH, rootState.api.response);
            })
        },
        save({ commit, rootState, dispatch }, payload) {
            commit(UPDATE_AUTH, payload);
            dispatch('api/post', { url: '/auth/update', data: payload }, ROOT).then(() => {
                console.log(rootState.api.response);
            })
        }
    },
};