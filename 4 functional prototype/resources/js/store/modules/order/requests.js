import Vue from 'vue';
import Vuex from 'vuex';
import {
    SET_ORDER_REQUESTS,
    UPDATE_FIELD_APPLY_ORDER_REQUESTS,
    SET_ORDER_REQUEST,
    CLEAR_ORDER_REQUESTS,
    SET_REQUESTS_FIELD
} from '../../mutation-types'
import { ROOT } from '../../constants';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: { // all requests of the order

        },
        data: { // personal apply for the order
            text: '',
            payment: 0
        }
    }),

    mutations: {
        [CLEAR_ORDER_REQUESTS](state) {
            state.list = {};
            state.data = { text: '', payment: 0 }
        },
        [SET_ORDER_REQUESTS](state, payload) {
            state.list = payload;
        },
        [SET_ORDER_REQUEST](state, payload) {
            state.data = payload;
        },
        [SET_REQUESTS_FIELD](state, payload) {
            var row = payload[0];
            var field = payload[1];
            var data = payload[2];
            state.list[row][field] = data;
        },
        [UPDATE_FIELD_APPLY_ORDER_REQUESTS](state, payload) {
            var field = payload[0];
            var data = payload[1];
            state.data[field] = data;
        }
    },

    actions: {

        requestOrder({ dispatch, rootState, state, commit }) {
            var data = {
                order_id: rootState.order.data.id,
                apply: state.data
            };

            dispatch('api/post', { url: '/order/request/put', data: data }, ROOT).then(() => {

                commit(SET_ORDER_REQUEST, rootState.api.response)
            });
        },

        withrawRequest({ dispatch, commit, rootState }) {
            dispatch('api/post', { url: '/order/request/withrawn', data: { order_id: rootState.order.data.id } }, ROOT).then(() => {
                commit(SET_ORDER_REQUEST, rootState.api.response)
            });
        },

        withrawAll({ dispatch, rootState }) {
            dispatch('api/post', { url: '/order/request/withrawAll', data: { order_id: rootState.order.data.id } }, ROOT);
        },

        deny({ dispatch, rootState }, request_id) {
            dispatch('api/post', { url: '/order/request/deny', data: { request_id: request_id } }, ROOT).then(() => {
                dispatch('updateRequestsStatus', { request_id: request_id, status: 'denied' });
            });

        },

        accept({ dispatch, rootState }, request_id) {
            dispatch('api/post', { url: '/order/request/accept', data: { request_id: request_id } }, ROOT).then(() => {
                var success = rootState.api.response
                if (success) {
                    dispatch('order/startPostmaker', '', ROOT);
                }
            });
            dispatch('updateRequestsStatus', { request_id: request_id, status: 'accepted' });
        },

        init({ commit, rootState }, payload) {
            var order_requests = payload.order_requests;

            commit(CLEAR_ORDER_REQUESTS);
            commit(SET_ORDER_REQUESTS, order_requests);
            commit(UPDATE_FIELD_APPLY_ORDER_REQUESTS, ['payment', rootState.order.data.payment]);

            for (var i in order_requests) {
                var order_request = order_requests[i];
                if (order_request.postmaker_id == rootState.auth.user.id) {
                    commit(SET_ORDER_REQUEST, order_request);
                }
            }
        },

        updateRequestsStatus({ state, commit }, payload) { /* expects {orderid: 123123, status: 'open'} */
            var request_id = payload.request_id;
            var status = payload.status;

            for (var i in state.list) {
                var request = state.list[i];
                if (request.id == request_id) {
                    commit(SET_REQUESTS_FIELD, [i, 'status', status]);
                }
            }

        }
    },
    modules: {

    },
};