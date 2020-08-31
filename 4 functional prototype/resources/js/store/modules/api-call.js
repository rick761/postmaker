import Vue from 'vue';
import Vuex from 'vuex';
import { CLEAR_API_RESPONSE, SET_API_RESPONSE } from '../mutation-types'
// import { ROOT } from '../constants'
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        response: []
    }),
    mutations: {
        [CLEAR_API_RESPONSE](state) {
            state.response = [];
        },
        [SET_API_RESPONSE](state, payload) {
            state.response = payload
        }
    },
    actions: {
        async post({ commit }, payload) {
            commit(CLEAR_API_RESPONSE);
            console.log('api-call', payload);
            var config = {
                method: 'post',
                url: payload.url,
                data: payload.data
            }

            await axios(config).then(response => {
                commit(SET_API_RESPONSE, response.data);
            });

        },
        async get({ commit }, payload) {

            commit(CLEAR_API_RESPONSE);

            var config = {
                method: 'get',
                url: payload,
            }

            await axios(config).then(response => {
                commit(SET_API_RESPONSE, response.data);
            });

        }
    },
};