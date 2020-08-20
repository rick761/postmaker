import Vue from 'vue';
import Vuex from 'vuex';
import {
    NEW_ORDER_DELIVERY_COMMENT,
    SET_ORDER_DELIVERY_COMMENT
} from '../../../mutation-types'
import { ROOT } from '../../../constants';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: []
    }),
    mutations: {
        [NEW_ORDER_DELIVERY_COMMENT](state, payload) {
            state.list.push(payload);
        },
        [SET_ORDER_DELIVERY_COMMENT](state, payload) {
            state.list = payload;
        },
    },
    actions: {
        comment({ commit, rootState, dispatch }, payload) {
            var msg = {
                user_id: rootState.auth.user.id,
                text: payload
            }

            dispatch('api/post', {
                url: '/order/delivery/comments/create',
                data: {
                    msg: payload,
                    deliveryId: rootState.order.delivery.data.id
                }
            }, ROOT).then(() => {
                var res = rootState.api.response;

                commit(NEW_ORDER_DELIVERY_COMMENT, res);
            });
        },

        get({ dispatch, rootState, commit }) {
            commit(SET_ORDER_DELIVERY_COMMENT, []);
            dispatch('api/get', '/order/delivery/comments/get/' + rootState.order.delivery.data.id, ROOT).then(() => {
                var res = rootState.api.response;
                commit(SET_ORDER_DELIVERY_COMMENT, res);
            });
        }
    }
}