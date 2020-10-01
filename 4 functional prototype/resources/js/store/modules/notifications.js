import Vue from 'vue';
import Vuex from 'vuex';
import Pusher from 'pusher-js';
import router from '../../router/index'
import { PUSHER_APP_KEY, PUSHER_APP_CLUSTER } from '../constants'
import {
    SET_NOTIFICATIONS,
    SET_NOTIFICATION,
    SET_READ,
    TOGGLE_NOTIFICATION_MODAL,
    OPEN_NOTIFICATION_MODAL,
    REMOVE_NOTIFICATION
} from '../mutation-types';
import { ROOT } from '../constants';

Vue.use(Vuex);
// Enable pusher logging - don't include this in production
Pusher.logToConsole = false;
const pusher = new Pusher(PUSHER_APP_KEY, {
    cluster: PUSHER_APP_CLUSTER,
});


export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: [],
        modal: false,
    }),

    mutations: {
        [SET_NOTIFICATIONS](state, payload) {
            for (var i in payload) {
                state.list.push(payload[i]);
            }
        },
        [SET_NOTIFICATION](state, payload) {
            state.list.unshift(payload);
        },
        [SET_READ](state, payload) {
            state.list.filter(item => item.id == payload.id)[0].read = 1;
        },
        [TOGGLE_NOTIFICATION_MODAL](state) {
            state.modal = !state.modal;
        },
        [OPEN_NOTIFICATION_MODAL](state) {
            state.modal = 1
        },
        [REMOVE_NOTIFICATION](state, payload) {
            for (var i in state.list) {
                var item = state.list[i];
                if (item.id == payload.id) {
                    state.list.splice(i, 1);
                }
            }
            // console.log('notif-state', state);
            // console.log('notif-payload', payload);
        }

    },
    getters: {
        UNREAD_NOTIFICATIONS(state) {
            return state.list.filter(item => item.read == 0).length;
        }
    },
    actions: {

        init({ commit, dispatch, rootState }) {
            var authUserid = rootState.auth.user.id;
            pusher.subscribe(`notification-channel.${authUserid}`).bind('App\\Events\\NewNotification', function(data) {

                var orderId = data.notification.url.split('/')[data.notification.url.split('/').length - 1];
                var isCurrentOrder = orderId == rootState.order.data.id;
                var hasOrderInRoute = router.currentRoute.path.split('/').filter(item => item == 'order').length;
                var isMessage = data.notification.text.split(' ')[0] == "Bericht:";

                // console.log(data, isMessage, hasOrderInRoute);

                if (hasOrderInRoute && isCurrentOrder) {
                    dispatch('order/messages/recieveFromNotifications', data.notification, ROOT);
                }

                if (!(isMessage && hasOrderInRoute)) {
                    //commit(OPEN_NOTIFICATION_MODAL);
                }

                commit(SET_NOTIFICATION, data.notification);

            });

            dispatch('api/get', 'notifications/get', ROOT).then(() => {
                var response = rootState.api.response;
                commit(SET_NOTIFICATIONS, response);

                if (response[0] && response[0].read == 0) {
                    //commit(OPEN_NOTIFICATION_MODAL);
                }
            });
        },

        read({ commit, dispatch }, payload) {
            commit('SET_READ', payload);
            dispatch('api/post', { url: 'notifications/read', data: payload }, ROOT);
        },

        remove({ dispatch, rootState, commit }, payload) {
            commit(REMOVE_NOTIFICATION, payload);
            dispatch('api/post', { url: 'notifications/remove', data: payload }, ROOT).then(() => {
                var response = rootState.api.response;;
                console.log(response);
            });
        }


    },
    modules: {

    },
};