import Vue from 'vue';
import Vuex from 'vuex';
import { SET_USER, CLEAR_USER } from '../mutation-types'
import { ROOT } from '../constants'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        data: {

        }
    }),
    mutations: {
        [CLEAR_USER](state) {
            state.data = {}
        },
        [SET_USER](state, payload) {
            state.data = payload
        },
    },
    actions: {

        async get_({ commit, dispatch, rootState }, payload) {
            await dispatch('api/get', '/user/' + payload, ROOT).then(() => {
                commit(SET_USER, rootState.api.response);
                // console.log(rootState.api.response);
            })
        },
    },
    modules: {

    },
};