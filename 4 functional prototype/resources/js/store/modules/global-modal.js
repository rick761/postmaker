import Vue from 'vue';
import Vuex from 'vuex';
import { TOGGLE_GLOBAL_MODAL, RESET_GLOBAL_MODAL, SET_ACTION, SET_PARAMETER, CLEAR_ACTION, SET_FIELDS } from '../mutation-types'
import { ROOT } from '../constants';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        data: {
            title: 'Weet u het zeker?',
            text: 'Klik op oke om door te gaan.'
        },
        open: false,
        action: '',
        parameter: ''
    }),
    mutations: {
        [TOGGLE_GLOBAL_MODAL](state) {
            state.open = !state.open;
        },
        [RESET_GLOBAL_MODAL](state) {
            state.data = {
                title: 'Weet u het zeker?',
                text: 'Klik op oke om door te gaan.'
            };
        },
        [SET_ACTION](state, payload) {
            state.action = payload;
        },
        [SET_PARAMETER](state, payload) {
            state.parameter = payload;
        },
        [CLEAR_ACTION](state) {
            state.action = "";
            state.parameter = "";
            state.data = {
                title: 'Weet u het zeker?',
                text: 'Klik op ja om door te gaan.'
            };
        },
        [SET_FIELDS](state, payload) {
            var title = payload[0];
            var text = payload[1];
            if (title) { state.data.title = title; }
            if (text) { state.data.text = text; }
        }
    },
    actions: {
        confirm({ commit, dispatch, state }) {
            commit(TOGGLE_GLOBAL_MODAL);
            dispatch(state.action, state.parameter, ROOT)
        },
        confirmAction({ commit }, payload) {

            commit(CLEAR_ACTION);
            commit(TOGGLE_GLOBAL_MODAL);

            var action = payload.action;
            var parameter = payload.parameter;
            var title = payload.title;
            var text = payload.text;


            commit(SET_ACTION, action);
            commit(SET_PARAMETER, parameter);
            commit(SET_FIELDS, [title, text]);

        }
    },
    modules: {

    },
};