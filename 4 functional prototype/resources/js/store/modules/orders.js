import Vue from 'vue';
import Vuex from 'vuex';
import { SET_ORDERS, SET_AVAILABLE_ORDERS, SET_REQUESTED_ORDERS, SET_ARCHIVED_ORDERS, ADD_SEARCH_KEYS_AVAILABLE_ORDERS } from '../mutation-types';
import { ROOT } from '../constants';


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: [

        ],
        open: [

        ],
        requested: [

        ],
        archived: [

        ],
    }),
    mutations: {

        [SET_ORDERS](state, payload) {
            state.list = payload
        },

        [SET_AVAILABLE_ORDERS](state, payload) {
            state.open = payload;
        },

        [ADD_SEARCH_KEYS_AVAILABLE_ORDERS](state) {

            for (var i in state.open) {
                state.open[i]['search_key'] = [];

                //add order tags
                state.open[i].order_tags.forEach(order_tag => {
                    state.open[i]['search_key'].push(order_tag.text);
                });

                //add display name                
                state.open[i]['search_key'].push(state.open[i].user.display_name);

            }


        },

        [SET_REQUESTED_ORDERS](state, payload) {
            state.requested = payload
        },

        [SET_ARCHIVED_ORDERS](state, payload) {
            state.archived = payload
        }

    },
    actions: {

        get({ dispatch, rootState, commit }) {
            commit('loader/TOGGLE_LOADER_SYSTEM_BAR_ON', null, ROOT);

            dispatch('api/get', '/orders/get', ROOT).then(() => {
                commit('loader/TOGGLE_LOADER_SYSTEM_BAR_OFF', null, ROOT);
                commit(SET_ORDERS, rootState.api.response)
            })
        },

        getAvailable({ dispatch, rootState, commit, state }) {
            commit('loader/TOGGLE_LOADER_SYSTEM_BAR_ON', null, ROOT);

            dispatch('api/get', '/orders/available', ROOT).then(() => {
                commit('loader/TOGGLE_LOADER_SYSTEM_BAR_OFF', null, ROOT);
                commit(SET_AVAILABLE_ORDERS, rootState.api.response)
                commit(ADD_SEARCH_KEYS_AVAILABLE_ORDERS);
            });
        },

        getRequested({ dispatch, commit, rootState }) {
            commit('loader/TOGGLE_LOADER_SYSTEM_BAR_ON', null, ROOT);

            dispatch('api/get', '/orders/requested', ROOT).then(() => {
                commit('loader/TOGGLE_LOADER_SYSTEM_BAR_OFF', null, ROOT);
                commit(SET_REQUESTED_ORDERS, rootState.api.response);
            });
        },

        getArchived({ dispatch, commit, rootState }) {
            commit('loader/TOGGLE_LOADER_SYSTEM_BAR_ON', null, ROOT);

            dispatch('api/get', '/orders/archived', ROOT).then(() => {
                commit('loader/TOGGLE_LOADER_SYSTEM_BAR_OFF', null, ROOT);
                commit(SET_ARCHIVED_ORDERS, rootState.api.response);

            });
        },

        init({ dispatch }) {
            dispatch('get');
            dispatch('getAvailable');
            dispatch('getRequested');
            dispatch('getArchived');
        },



    },

};