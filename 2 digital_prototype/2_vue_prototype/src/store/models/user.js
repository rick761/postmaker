import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        id: '',
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        type: ''
    }),
    mutations: {
        SET_ID(state, payload) {
            state.id = payload;
        },
        SET_FIRST_NAME(state, payload) {
            state.first_name = payload;
        },
        SET_LAST_NAME(state, payload) {
            state.last_name = payload;
        },
        SET_EMAIL(state, payload) {
            state.email = payload;
        },
        SET_PHONE(state, payload) {
            state.phone = payload;
        },
        SET_TYPE(state, payload) {
            state.type = payload;
        },
        CLEAR_USER(state){
            state.id= '';
            state. first_name= '';
            state.last_name= '';
            state.email= '';
            state.phone= '';
            state.type= '';
        }
    },
    actions: {
        set({ commit }, payload) {       
              
            if (payload.id) {
                commit('SET_ID', payload.id);
            }
            if (payload.first_name) {
                commit('SET_FIRST_NAME', payload.first_name);
            }
            if (payload.last_name) {
                commit('SET_LAST_NAME', payload.last_name);
            }
            if (payload.email) {
                commit('SET_EMAIL', payload.email);
            }
            if (payload.phone) {
                commit('SET_PHONE', payload.phone);
            }
            if (payload.type) {
                commit('SET_TYPE', payload.type);
            }
            
        },
        clear({commit}){
            commit('CLEAR_USER');
        }
    },
    modules: {

    },
};