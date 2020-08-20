import Vue from 'vue';
import Vuex from 'vuex';
import { SET_ORDER_MESSAGES } from '../../mutation-types'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: []
    }),
    mutations: {
        [SET_ORDER_MESSAGES](state, payload) {
            state.list = payload;
        }
    },
    actions: {},
    modules: {

    },
};