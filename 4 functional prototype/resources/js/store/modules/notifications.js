import Vue from 'vue';
import Vuex from 'vuex';
import Pusher from 'pusher-js';
import { PUSHER_APP_KEY, PUSHER_APP_CLUSTER } from '../constants'
import {
    SET_NOTIFICATIONS,
    SET_NOTIFICATION,
    SET_READ,
    TOGGLE_NOTIFICATION_MODAL,
    OPEN_NOTIFICATION_MODAL
} from '../mutation-types';


const root = { root: true };

Vue.use(Vuex);

// Enable pusher logging - don't include this in production

Pusher.logToConsole = true;
const pusher = new Pusher(PUSHER_APP_KEY, {
    cluster: PUSHER_APP_CLUSTER,
    // authEndpoint: `/broadcasting/auth`,
    // auth: {
    //     // headers: {
    //     //     Authorization: `Bearer ${localStorage.getItem('token')}`
    //     // }
    // }
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
                commit(SET_NOTIFICATION, data.notification);
                commit(OPEN_NOTIFICATION_MODAL);
            });

            dispatch('api/get', 'notifications/get', root).then(() => {
                var response = rootState.api.response;
                commit(SET_NOTIFICATIONS, response);
                if (response[0] && response[0].read == 0) {
                    commit(OPEN_NOTIFICATION_MODAL);
                }
            });
        },

        read({ commit, dispatch }, payload) {
            commit('SET_READ', payload);
            dispatch('api/post', { url: 'notifications/read', data: payload }, root);
        },

        remove({ dispatch, rootState }, payload) {
            console.log(payload);
            dispatch('api/post', { url: 'notifications/remove', data: payload }, root).then(() => {
                var response = rootState.api.response;;
                console.log(response);
            });
        }


    },
    modules: {

    },
};