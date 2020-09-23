import Vue from 'vue';
import Vuex from 'vuex';
import comments from './delivery/delivery-comment'
import {
    SET_OPEN_MODAL,
    SET_NEW_MODAL,
    TOGGLE_OPEN_MODAL,
    TOGGLE_NEW_MODAL,
    SET_DELIVERYS,
    UPDATE_FIELD_DELIVERY,
    CLEAR_DELIVERY,
    ADD_DELIVERY_FILES,
    DEL_DELIVERY_FILE,
    ADD_TO_DELIVERYS,
    SET_FINAL_MODAL,
    TOGGLE_FINAL_MODAL,
    SET_DELIVERY_INVOICE,
    SET_DELIVERY
} from '../../mutation-types'
import { ROOT } from '../../constants';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden

    state: () => ({
        data: { //current
            title: '',
            text: '',
            files: [],
            type: 'pre',
            invoice: [],
            rate: null
        },
        list: [ //deliverys
        ],
        open: false,
        new: false,
        final: false,
    }),

    mutations: {
        //modals
        [SET_OPEN_MODAL](state, payload) {
            state.open = payload;
        },
        [TOGGLE_OPEN_MODAL](state) {
            state.open = !state.open;
        },
        [SET_NEW_MODAL](state, payload) {
            state.new = payload;
        },
        [TOGGLE_NEW_MODAL](state) {
            state.new = !state.new;
        },
        [SET_FINAL_MODAL](state, payload) {
            state.final = payload;
        },
        [TOGGLE_FINAL_MODAL](state) {
            state.final = !state.final;
        },
        //end modals

        [SET_DELIVERY_INVOICE](state, payload) {
            state.data.invoice = payload;
        },
        [SET_DELIVERYS](state, payload) {
            state.list = payload;
        },
        [SET_DELIVERY](state, payload) {
            state.data = payload;
        },
        [ADD_TO_DELIVERYS](state, payload) {
            state.list.push(payload);
        },
        [UPDATE_FIELD_DELIVERY](state, payload) {
            var field = payload[0];
            var val = payload[1];
            state.data[field] = val;
        },
        [ADD_DELIVERY_FILES](state, payload) {
            state.data.files = state.data.files.filter((v, i, a) => a.indexOf(v) === i);

            for (var i in payload) {
                var file = payload[i];
                state.data.files.push(file);
            }

            state.data.files = state.data.files.filter((v, i, a) => a.indexOf(v) === i);
        },
        [DEL_DELIVERY_FILE](state, i) {
            state.data.files.splice(i, 1);
        },

        [CLEAR_DELIVERY](state) {
            state.data = {
                title: '',
                text: '',
                files: [],
                type: 'pre',
                invoice: [],
                rate: null
            }
        }
    },
    actions: {
        create({ state, commit, dispatch, rootState }) {

            //FILENAMES            
            var file_names = [];
            for (var i in state.data.files) {
                file_names.push(state.data.files[i].name);
            }

            dispatch('api/post', { url: '/order/delivery/create', data: { delivery: state.data, order_delivery_files: file_names, order_id: rootState.order.data.id } }, ROOT).then(() => {
                var res = rootState.api.response;
                if (res) {

                    dispatch('file/upload', {
                        type: 'order_delivery',
                        files: state.data.files,
                        folder: rootState.order.data.id
                    }, ROOT);

                    dispatch('order/delivered', '', ROOT);
                    commit(ADD_TO_DELIVERYS, res);
                    commit(CLEAR_DELIVERY);
                }
            });
        },
        createFinal({ state, commit, dispatch, rootState }) {

            //FILENAMES            
            var file_names = [];
            var invoice_name = state.data.invoice.name;
            for (var i in state.data.files) {
                file_names.push(state.data.files[i].name);
            }

            dispatch('api/post', {
                url: '/order/delivery/final_create',
                data: {
                    delivery: state.data,
                    order_delivery_files: file_names,
                    invoice: invoice_name,
                    order_id: rootState.order.data.id,
                }
            }, ROOT).then(() => {
                var res = rootState.api.response;
                if (res) {

                    dispatch('file/upload', {
                        type: 'order_delivery',
                        files: state.data.files,
                        folder: rootState.order.data.id
                    }, ROOT);

                    dispatch('order/final_delivered', '', ROOT);
                    commit(ADD_TO_DELIVERYS, res);
                    commit(CLEAR_DELIVERY);
                }
            });

            commit(SET_FINAL_MODAL, false);
        },

        rate({ dispatch, state, rootState, commit }, $type) {
            dispatch('api/post', {
                url: '/order/delivery/rate',
                data: {
                    order_delivery_id: state.data.id,
                    rate: $type
                }
            }, ROOT).then(() => {
                var res = rootState.api.response;
                commit(UPDATE_FIELD_DELIVERY, ['rate', res]);
            });
        },
    },
    modules: {
        comments
    }
};