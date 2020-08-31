import Vue from 'vue';
import Vuex from 'vuex';
import { SET_ARCHIVED_DELIVERY_ORDERS, SET_SHOWN_ARCHIVED_FILES } from '../../mutation-types'
import { ROOT } from '../../constants'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({

        data: {

        },
        list: [

        ],
        archived: [

        ]

    }),
    mutations: {
        [SET_ARCHIVED_DELIVERY_ORDERS](state, payload) {
            state.archived = payload;
        },
        [SET_SHOWN_ARCHIVED_FILES](state, payload) {
            state.data = payload;
        }
    },
    actions: {
        getSuccessFullArchived({ dispatch, rootState, commit }) {

            dispatch('api/get', '/orders/archived/successfull', ROOT).then(() => {
                commit(SET_ARCHIVED_DELIVERY_ORDERS, rootState.api.response);
            });

        },

        show({ dispatch, rootState, commit }, payload) {

            var delivery_files = payload.delivery_files;

            dispatch('api/post', { url: '/auth/delivery/show', data: payload }, ROOT).then(() => {
                commit(SET_SHOWN_ARCHIVED_FILES, rootState.api.response);
            });

        },

        hide({ dispatch, rootState }, payload) {

            dispatch('api/post', { url: '/auth/delivery/hide', data: payload }, ROOT).then(() => {
                console.log(rootState.api.response);
            });

        },

        get() {
            // console.log('get_displayed_delivery_files')
        }
    },

};