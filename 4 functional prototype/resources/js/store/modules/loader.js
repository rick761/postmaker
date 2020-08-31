import Vue from 'vue';
import Vuex from 'vuex';
import { TOGGLE_LOADER_SYSTEM_BAR_ON, TOGGLE_LOADER_SYSTEM_BAR_OFF } from '../mutation-types'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        data: {
            systembar: false
        }
    }),
    mutations: {
        [TOGGLE_LOADER_SYSTEM_BAR_ON](state) {
            state.data.systembar = true;

        },
        [TOGGLE_LOADER_SYSTEM_BAR_OFF](state) {
            state.data.systembar = false;
        }
    },
    actions: {},
    modules: {

    },
};