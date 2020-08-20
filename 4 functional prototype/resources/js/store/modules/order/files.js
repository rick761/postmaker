import Vue from 'vue';
import Vuex from 'vuex';
import {
    ADD_ORDER_FILES,
    DEL_ORDER_FILE,
    SET_ORDER_FILES,
    ADD_TMP_FILES,
    DEL_TMP_FILES,
    DEL_ALL_TMP_FILES,
    CLEAR_ORDER_FILES
} from '../../mutation-types';
import { ROOT } from '../../constants';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        tmp_files: [],
        list: []
    }),
    mutations: {
        [ADD_ORDER_FILES](state, payload) {
            for (var i in payload) {
                state.list.push({ url: payload[i].name });
            }
            state.list = state.list.filter((v, i, a) => a.indexOf(v) === i);
        },
        [DEL_ORDER_FILE](state, payload) {
            for (var i in state.list) {
                if (state.list[i].id == payload) {
                    state.list.splice(i, 1);
                }
            }
        },
        [SET_ORDER_FILES](state, payload) {
            state.list = payload;
        },
        [ADD_TMP_FILES](state, payload) {
            state.tmp_files = state.tmp_files.filter((v, i, a) => a.indexOf(v) === i);
            for (var i in payload) {
                var file = payload[i];
                state.tmp_files.push(file);
            }
            state.tmp_files = state.tmp_files.filter((v, i, a) => a.indexOf(v) === i);
        },
        [DEL_TMP_FILES](state, i) {
            state.tmp_files.splice(i, 1);
        },
        [DEL_ALL_TMP_FILES](state) {
            state.tmp_files = [];
        },
        [CLEAR_ORDER_FILES](state) {
            state.tmp_files = [];
            state.list = [];
        }

    },
    actions: {

        save({ state, dispatch, rootState, commit }) {
            if (state.tmp_files.length) {

                var file_names = [];
                for (var i in state.tmp_files) {
                    file_names.push(state.tmp_files[i].name);
                }

                dispatch('api/post', { url: '/order/files/save', data: { order_files: file_names, order_id: rootState.order.data.id } }, ROOT).then(() => {
                    var res = rootState.api.response;
                    if (res) {
                        dispatch('file/upload', { type: 'order_files', files: state.tmp_files, folder: rootState.order.data.id }, ROOT);
                        commit(SET_ORDER_FILES, state.tmp_files);
                        commit(DEL_ALL_TMP_FILES);
                    }
                });


            }
        },

        deleteFile({ commit, dispatch, rootState }, id) {
            dispatch('api/get', 'order/files/delete/' + id, ROOT).then(() => {
                var res = rootState.api.response;

                if (res) {
                    commit(DEL_ORDER_FILE, id);
                }
            });

        }
    },
};