import Vue from 'vue';
import Vuex from 'vuex';
import { SET_AUTH, SET_AUTH_FIELD, SET_USER_IMAGES } from '../mutation-types';
import { ROOT } from '../constants'
import images from './auth/images'

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
            await dispatch('api/get', '/auth', ROOT).then(() => {
                commit(SET_AUTH, rootState.api.response);

                if (state.user.user_images) {
                    commit('images/' + SET_USER_IMAGES, state.user.user_images)
                }
                console.log(rootState.api.response);
            })
        },

        save({ state, dispatch, rootState }) {
            dispatch('api/post', { url: '/auth/update', data: state.user }, ROOT).then(() => {
                //console.log(rootState.api.response)
            });
            dispatch('images/save');
        },

    },

    modules: {
        images
    }
};