import Vue from 'vue';
import Vuex from 'vuex';
import {
    SET_STATE,
    SET_PAYMENT,
    SET_DELIVER,
    SET_DESCRIPTION,
    SET_TITLE,
    SET_ORDER,
    SET_TYPE,
    CLEAR_ORDER,
    SET_ORDER_PAGE,
    SET_ORDER_DESCRIPTION,
    SET_ORDER_TAGS,
    SET_DELIVERYS,
    SET_ORDER_FILES,
    SET_ORDER_MESSAGES,
    FIX_FORMAT_ORDER
} from '../mutation-types'
import { ROOT } from '../constants';
import router from '../../router/index'

//store modules
import descriptions from './order/descriptions'
import requests from './order/requests'
import files from './order/files'
import tags from './order/tags'
import delivery from './order/delivery'
import messages from './order/messages'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden

    state: () => ({
        data: {
            payment: 0,
        },
        order_page_handler: '',
        addMonths: (date, months) => {
            var d = date.getDate();
            date.setMonth(date.getMonth() + +months);
            if (date.getDate() != d) { date.setDate(0); }
            return date;
        }
    }),

    mutations: {
        [CLEAR_ORDER](state) {
            state.data = {
                payment: 0,
                deliver: state.addMonths(new Date(), 2).toISOString().substr(0, 10),
            }
        },
        [SET_PAYMENT](state, payload) {
            state.data.payment = payload
        },
        [SET_DELIVER](state, payload) {
            state.data.deliver = payload
        },
        [SET_DESCRIPTION](state, payload) {
            state.data.description = payload
        },
        [SET_TITLE](state, payload) {
            state.data.title = payload
        },
        [SET_ORDER](state, payload) {
            state.data = payload
        },
        [SET_TYPE](state, payload) {
            state.data.type = payload
        },
        [SET_ORDER_PAGE](state, payload) {
            state.order_page_handler = payload;
        },
        [SET_STATE](state, payload) {
            state.data.state = payload
        },
        [FIX_FORMAT_ORDER](state) {
            if (state.data.deliver) {
                const [unknown1, month, unknown2] = state.data.deliver.split('-');
                var year, day;

                if (unknown1.length == 4) {
                    year = unknown1;
                    day = unknown2;
                }
                if (unknown2.length == 4) {
                    year = unknown2;
                    day = unknown1;
                }
                state.data.deliver = `${year}-${month}-${day}`;
            }

        }
    },

    actions: {

        async orderPageHandler({ state, commit, rootState }, type) {
            var currentRoute = router.history.current.fullPath;
            await commit(SET_ORDER_PAGE, type);


            //kick out of page
            if (state.order_page_handler == 'exit') {
                router.push({ path: '/' });
            }

            //creation 
            if (state.order_page_handler == 'create') {
                let newRoute = '/requester/order/edit/' + state.data.id;
                if (currentRoute != newRoute) {
                    router.push({
                        path: '/requester/order/edit/' + state.data.id
                    })
                }
            };

            //public 
            if (state.order_page_handler == 'open') {
                let newRoute = '/order/open/' + state.data.id;
                if (currentRoute != newRoute) {
                    router.push({
                        path: newRoute
                    })
                }
            };

            //progress 
            if (
                state.order_page_handler == 'progress' ||
                state.order_page_handler == 'delivered' ||
                state.order_page_handler == 'quit_postmaker' ||
                state.order_page_handler == 'delivery_accepted' ||
                state.order_page_handler == 'final_delivered'
            ) {
                let userType = rootState.auth.user.type;
                let newRoute = '/' + userType + '/order/' + state.data.id;
                if (currentRoute != newRoute) {

                    router.push({
                        path: newRoute
                    })
                }
            };

            //archived
            if (
                state.order_page_handler == 'quit' ||
                state.order_page_handler == 'removed' ||
                state.order_page_handler == 'recieved_payment'
            ) {
                let newRoute = '/archive/order/' + state.data.id;
                if (currentRoute != newRoute) {
                    router.push({
                        path: newRoute
                    })
                }

            }

        },



        get({ state, dispatch, rootState, commit }, orderId = null) {
            if (!orderId) return; //order is already loaded or no id is given
            commit('loader/TOGGLE_LOADER_SYSTEM_BAR_ON', null, ROOT);

            dispatch('api/get', '/order/get/' + orderId, ROOT).then(() => {
                var response = rootState.api.response;
                commit('loader/TOGGLE_LOADER_SYSTEM_BAR_OFF', null, ROOT);

                if (!response) {
                    dispatch('orderPageHandler', 'exit');
                    return;
                };

                commit(SET_ORDER, response);


                //setters
                commit('descriptions/' + SET_ORDER_DESCRIPTION, response.order_descriptions);
                commit('files/' + SET_ORDER_FILES, response.order_files)
                commit('tags/' + SET_ORDER_TAGS, response.order_tags);
                commit('delivery/' + SET_DELIVERYS, response.order_deliveries);
                commit('messages/' + SET_ORDER_MESSAGES, response.order_messages);
                dispatch('requests/init', response);
                dispatch('orderPageHandler', state.data.state);

            });

        },


        async create({ state, commit, dispatch, rootState }) {
            commit(FIX_FORMAT_ORDER);
            await dispatch('api/post', { url: '/order/create', data: state.data }, ROOT).then(() => {
                var newOrder = rootState.api.response;
                commit(SET_ORDER, newOrder);
                dispatch('update');
            });
        },


        async update({ state, dispatch, rootState, commit }, refresh = true) {
            commit(FIX_FORMAT_ORDER);

            await dispatch('api/post', { url: '/order/update', data: state.data }, ROOT).then(() => {
                if (rootState.api.response) {
                    router.push({ path: '/order/open/' + state.data.id });
                }
            });

            var orderId = state.data.id;
            dispatch('descriptions/save', orderId)
            dispatch('files/save');
            dispatch('tags/save');
        },

        publish({ commit, dispatch }) {
            commit(SET_STATE, 'open');
            dispatch('orderPageHandler', 'open');
            dispatch('update');
        },

        edit({ state, commit, dispatch }) {
            commit(SET_STATE, 'create');
            dispatch('orderPageHandler', 'create');
            dispatch('update').then(() => {
                var order_id = state.data.id;
                dispatch('requests/withrawAll', order_id);
            });
        },

        delivered({ commit, dispatch }) {
            commit(SET_STATE, 'delivered');
            dispatch('orderPageHandler', 'delivered');
            dispatch('update');
        },

        startPostmaker({ commit, dispatch, state }) {
            commit(SET_STATE, 'progress');
            dispatch('api/get', '/order/connect/postmaker/' + state.data.id, ROOT);
            dispatch('orderPageHandler', 'progress');
            dispatch('update');
        },

        remove({ commit, dispatch, rootState }, payload) {
            var removeOrderFromOutside = (payload != '' && payload != null)
            if (removeOrderFromOutside) {
                dispatch('api/post', { data: { id: payload, state: 'removed' }, url: '/order/update' }, ROOT).then(() => {
                    var res = rootState.api.response;
                    if (res) {
                        dispatch('orders/get', '', ROOT)
                    }
                });
                return;
            }

            commit(SET_STATE, 'removed');
            dispatch('orderPageHandler', 'removed');
            dispatch('update');
        },

        quit_postmaker({ commit, dispatch }) {
            commit(SET_STATE, 'quit_postmaker');
            dispatch('orderPageHandler', 'quit_postmaker');
            dispatch('update');
        },

        quit({ commit, dispatch }) {
            commit(SET_STATE, 'quit');
            dispatch('orderPageHandler', 'quit');
            dispatch('update');
        },

        progress({ commit, dispatch }) {
            commit(SET_STATE, 'progress');
            dispatch('orderPageHandler', 'progress');
            dispatch('update');
        },

        accept({ commit, dispatch }) {
            commit(SET_STATE, 'delivery_accepted');
            dispatch('orderPageHandler', 'delivery_accepted');
            dispatch('update');
        },

        recieved_payment({ commit, dispatch }) {
            commit(SET_STATE, 'recieved_payment');
            dispatch('orderPageHandler', 'recieved_payment');
            dispatch('update');
        },

        final_delivered({ commit, dispatch }) {
            commit(SET_STATE, 'final_delivered');
            dispatch('orderPageHandler', 'final_delivered');
            dispatch('update');
        },

        like({ state, dispatch, rootState }) {
            dispatch('api/get', `/order/like/${state.data.id}`, ROOT).then(() => {

            });
        }




    },

    modules: {
        descriptions,
        requests,
        files,
        tags,
        delivery,
        messages
    },

}