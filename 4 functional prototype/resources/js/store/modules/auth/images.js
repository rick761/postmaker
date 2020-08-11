import Vue from 'vue';
import Vuex from 'vuex';
import { ADD_USER_IMAGES, DEL_USER_IMAGE, SET_USER_IMAGES } from '../../mutation-types';
import { ROOT } from '../../constants';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: []
    }),
    mutations: {
        [ADD_USER_IMAGES](state, payload) {
            for (var i in payload) {
                state.list.push({ url: payload[i].name });
            }
            state.list = state.list.filter((v, i, a) => a.indexOf(v) === i);
        },
        [DEL_USER_IMAGE](state, payload) {
            state.list.splice(payload, 1);
        },
        [SET_USER_IMAGES](state, payload) {
            state.list = payload;
        }
    },
    actions: {
        save({ state, dispatch, rootState }) {
            dispatch('api/post', { url: '/auth/update', data: { user_images: state.list } }, ROOT).then(() => {
                //console.log(rootState.api.response)
            });
        }
    },
};