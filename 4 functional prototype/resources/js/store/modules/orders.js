import Vue from 'vue';
import Vuex from 'vuex';
import { SET_ORDERS, SET_AVAILABLE_ORDERS, SET_REQUESTED_ORDERS } from '../mutation-types';
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

        ]
    }),
    mutations: {
        [SET_ORDERS](state, payload) {
            state.list = payload
        },
        [SET_AVAILABLE_ORDERS](state, payload) {
            state.open = payload
        },
        [SET_REQUESTED_ORDERS](state, payload) {
            state.requested = payload
        }
    },
    actions: {

        get({ dispatch, rootState, commit }) {
            dispatch('api/get', '/orders/get', ROOT).then(() => {
                commit(SET_ORDERS, rootState.api.response)
                    // console.log(rootState.api.response);
            })
        },

        getAvailable({ dispatch, rootState, commit, state }) {
            dispatch('api/get', '/orders/available', ROOT).then(() => {
                commit(SET_AVAILABLE_ORDERS, rootState.api.response)
                console.log(state.open);
            });
        },

        getRequested({ dispatch, commit, rootState }) {
            dispatch('api/get', '/orders/requested', ROOT).then(() => {
                commit(SET_REQUESTED_ORDERS, rootState.api.response);
                // console.log(rootState.api.response);
            });
        },

        init({ dispatch }) {
            dispatch('get');
            dispatch('getAvailable');
            dispatch('getRequested');
        }

    },

};