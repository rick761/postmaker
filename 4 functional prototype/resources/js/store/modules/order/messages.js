import Vue from 'vue';
import Vuex from 'vuex';
import { SET_ORDER_MESSAGES, NEW_ORDER_MESSAGE } from '../../mutation-types'
import { ROOT } from '../../constants';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: []
    }),
    mutations: {
        [SET_ORDER_MESSAGES](state, payload) {
            state.list = payload;
        },
        [NEW_ORDER_MESSAGE](state, payload) {
            state.list.push(payload);
        },
    },
    actions: {
        send({ commit, rootState, dispatch }, payload) {
            var file = payload.file;
            var data = {
                order_id: rootState.order.data.id,
                text: payload.msg,
                url: ''
            };

            if (file) {
                data.url = file.name;
            }

            dispatch('api/post', { url: '/order/message/send', data }, ROOT).then(() => {
                var res = rootState.api.response;
                commit(NEW_ORDER_MESSAGE, res);
            });

        },
        recieveFromNotifications({ rootState, commit }, payload) {
            var text = payload.text.substr(9);

            if (text.includes('{{')) {
                text = text.substr(0, text.indexOf('{{'));
            }

            var url = '';

            if (payload.text.includes('{{')) {
                url = payload.text.substring(
                    payload.text.lastIndexOf("{{") + 2,
                    payload.text.lastIndexOf("}}")
                )
                console.log('UWL', url)
            }

            var user_id = (rootState.auth.user.id == rootState.order.user_id) ? rootState.order.postmaker_id : rootState.order.user_id;

            var data = {
                order_id: rootState.order.data.id,
                user_id: user_id,
                text: text,
                url: url
            }

            commit(NEW_ORDER_MESSAGE, data);

        }
    },

};