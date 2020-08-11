import Vue from 'vue';
import Vuex from 'vuex';
import order from '../models/order';
import request from '../support/request'

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        data: {

        }
    }),
    mutations: {},
    actions: {

        load({ dispatch, commit,state }, payload) {
            commit('loader/SET_0_ON',null,{root:true});            
            dispatch('order/reset');
            dispatch('request/get','api/order/view/'+payload).then(()=>{
                var response = state.request.RESPONSE;                  
                if(response || response.length){
                     dispatch('order/set', response);
                }  
                commit('loader/SET_0_OFF',null,{root:true});
            });            
        },     

    },
    modules: {
        order,        
        request
    },
};