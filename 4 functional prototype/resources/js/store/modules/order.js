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
    SET_ORDER_REQUESTS,
    UPDATE_FIELD_APPLY_ORDER_REQUESTS,
    SET_ORDER_FILES
} from '../mutation-types'
import { ROOT } from '../constants';
import router from '../../router/index'

//store modules
import descriptions from './order/descriptions'
import requests from './order/requests'
import files from './order/files'
import tags from './order/tags'

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
            if (state.order_page_handler == 'progress') {
                let userType = rootState.auth.user.type;
                let newRoute = '/' + userType + '/order/' + state.data.id;
                if (currentRoute != newRoute) {
                    router.push({
                        path: newRoute
                    })
                }
            };

        },



        get({ state, dispatch, rootState, commit }, orderId = null) {
            if (!orderId) return; //order is already loaded or no id is given

            dispatch('api/get', '/order/get/' + orderId, ROOT).then(() => {
                var response = rootState.api.response;
                console.log('retrieved order', response);

                if (!response) {
                    dispatch('orderPageHandler', 'exit');
                    return;
                };

                commit(SET_ORDER, response);

                //setters
                commit('descriptions/' + SET_ORDER_DESCRIPTION, response.order_descriptions);
                commit('files/' + SET_ORDER_FILES, response.order_files)
                commit('tags/' + SET_ORDER_TAGS, response.order_tags);

                dispatch('orderPageHandler', state.data.state);

            });

        },


        async create({ state, commit, dispatch, rootState }) {

            await dispatch('api/post', { url: '/order/create', data: state.data }, ROOT).then(() => {
                var newOrder = rootState.api.response;
                commit(SET_ORDER, newOrder);
                dispatch('update');
            });

        },



        async update({ state, dispatch, rootState }) {

            await dispatch('api/post', { url: '/order/update', data: state.data }, ROOT).then(() => {
                if (rootState.api.response) {
                    router.push({ path: '/' + rootState.auth.user.type + '/orders' });
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


        startPostmaker({ commit, dispatch, rootState }) {
            commit(SET_STATE, 'progress');
            dispatch('orderPageHandler', 'progress');

            dispatch('update').then(() => {
                dispatch('api/get', '/order/connect/postmaker/' + rootState.order.id, ROOT);
                console.log('/order/connect/postmaker/' + rootState.order.id);
            });
        }


    },

    modules: {
        descriptions,
        requests,
        files,
        tags
    },

}