import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        data: {

        }
    }),
    mutations: {},
    actions: {},
    modules: {

    },
};