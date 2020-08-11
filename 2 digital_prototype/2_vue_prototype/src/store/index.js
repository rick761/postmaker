import Vue from 'vue';
import Vuex from 'vuex';
import auth from './module/auth';
import orders from './module/orders';
import order_page from './module/order_page';
import profile from './module/profile';
import loader from './support/loader';
import request from './support/request';
import errors from './support/errors';
import constants from './support/constants';
import notifications from './models/notifications'

Vue.use(Vuex);

export default new Vuex.Store({
    namespaced: true,
    state: () => ({

    }),
    mutations: {

    },
    actions: {
        clearContent({commit}){
            commit('orders/CLEAR');
            commit('order_page/order/CLEAR');
        }
    },
    modules: {
        auth,
        orders,
        order_page,
        profile,
        loader,
        request,
        errors,
        constants,
        notifications
    },

});