import Vue from 'vue';
import Vuex from 'vuex';
import { SET_AUTH, SET_AUTH_FIELD, SET_USER_IMAGES, SET_SHOWN_ARCHIVED_FILES } from '../mutation-types';
import { ROOT } from '../constants'
import images from './auth/images'
import archivedDelivery from './auth/archived-delivery'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({ user: {} }),
    mutations: {

        [SET_AUTH](state, payload) {
            state.user = payload
        },

        [SET_AUTH_FIELD](state, payload) {
            var field = payload[0];
            var value = payload[1];
            state.user[field] = value;
        },

    },
    actions: {

        async get_({ state, commit, dispatch, rootState }) {
            commit('loader/TOGGLE_LOADER_SYSTEM_BAR_ON', null, ROOT);
            await dispatch('api/get', '/auth', ROOT).then(() => {
                commit('loader/TOGGLE_LOADER_SYSTEM_BAR_OFF', null, ROOT);
                commit(SET_AUTH, rootState.api.response);
                console.log('auth', rootState.api.response);

                if (state.user.user_images) {
                    commit('images/' + SET_USER_IMAGES, state.user.user_images)
                }

                if (state.user.user_show_deliverys) {
                    commit('archivedDelivery/' + SET_SHOWN_ARCHIVED_FILES, state.user.user_show_deliverys)
                }

            })
        },

        save({ state, dispatch, rootState }) {
            dispatch('api/post', { url: '/auth/update', data: state.user }, ROOT).then(() => {

            });
            dispatch('images/save');
        },

    },

    modules: {
        images,
        archivedDelivery
    }
};