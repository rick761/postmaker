import Vue from 'vue';
import Vuex from 'vuex';
import { CLOSE_PREVIEW_IMAGE, SHOW_PREVIEW_IMAGE, SET_PREVIEW_URL, SET_PREVIEW_TITLE } from '../mutation-types'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        show: false,
        url: '',
        title: ''
    }),
    mutations: {
        [CLOSE_PREVIEW_IMAGE](state) {
            state.show = false;
        },
        [SHOW_PREVIEW_IMAGE](state) {
            state.show = true;
        },
        [SET_PREVIEW_URL](state, payload) {
            state.url = payload
        },
        [SET_PREVIEW_TITLE](state, payload) {
            state.title = payload
        }
    },
    actions: {
        close({ commit }) {
            commit(SET_PREVIEW_URL, '');
            commit(SET_PREVIEW_TITLE, '');
            commit(CLOSE_PREVIEW_IMAGE);
        },
        preview({ commit }, payload) {
            commit(SET_PREVIEW_URL, payload)
            commit(SET_PREVIEW_TITLE, payload.split('/')[payload.split('/').length - 1]);
            commit(SHOW_PREVIEW_IMAGE);
        }
    },

};