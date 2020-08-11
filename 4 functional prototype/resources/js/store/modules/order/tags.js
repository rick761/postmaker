import Vue from 'vue';
import Vuex from 'vuex';
import { SET_ORDER_TAGS, DEL_ORDER_TAG, ADD_ORDER_TAG, CLEAR_ORDER_TAGS } from '../../mutation-types'
import { ROOT } from '../../constants';


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: [],
    }),
    mutations: {
        [SET_ORDER_TAGS](state, payload) {
            state.list = payload;
        },
        [ADD_ORDER_TAG](state, payload) {
            state.list.push(payload);
            state.list.filter((v, i, a) => a.indexOf(v) === i);
        },
        [DEL_ORDER_TAG](state, payload) {
            state.list.splice(payload, 1)
        },
        [CLEAR_ORDER_TAGS](state) {
            state.list = [];
        }
    },
    actions: {
        save({ state, dispatch, rootState }) {
            dispatch('api/post', { url: '/order/tags/save', data: { tags: state.list, order_id: rootState.order.data.id } }, ROOT).then(() => {
                var response = rootState.api.response;
                console.log('RES', response);
            })
        },
    },

};