import Vue from 'vue';
import Vuex from 'vuex';
import {
    SET_ORDER_DESCRIPTION,
    ADD_ORDER_DESCRIPTION,
    DEL_ORDER_DESCRIPTION,
    UPDATE_FIELD_ORDER_DESCRIPTION
} from '../../mutation-types'
import { ROOT } from '../../constants';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: []
    }),
    mutations: {
        [SET_ORDER_DESCRIPTION](state, payload) {
            state.list = payload;
        },
        [ADD_ORDER_DESCRIPTION](state) {
            state.list.push({ text: '' });
        },
        [DEL_ORDER_DESCRIPTION](state, payload) {
            state.list.splice(payload, 1);
        },
        [UPDATE_FIELD_ORDER_DESCRIPTION](state, payload) {
            var row = payload[0];
            var field = payload[1];
            var val = payload[2];
            state.list[row][field] = val;

        }
    },
    actions: {
        save({ state, dispatch, rootState }, payload) {
            var orderId = payload;

            dispatch('api/post', { url: '/order/descriptions/save', data: { descriptions: state.list, orderId: orderId } }, ROOT).then(() => {

            });


        }
    },
    modules: {

    },
};