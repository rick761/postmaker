import Vue from 'vue';
import Vuex from 'vuex';
const root = {root:true}


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: []        
    }),
    mutations: {
        SET_DELIVERYS(state,payload){
            state.list = payload;
        },
        ADD_IMAGES: function (state,payload){
            for(var i in payload)
                state.list.push(payload[i])
        },

    },
    actions: {
        set({commit},payload){
            commit('SET_DELIVERYS',payload);  
        },

        upload({commit,rootState,dispatch},payload){
            payload.append('order_id', rootState.order_page.order.id);             
            commit('loader/SET_9_ON',null,root);
            dispatch( 'request/file', {url:'api/order/delivery/upload', data:payload }, root ).then( () => {
                var response = rootState.request.RESPONSE;                 
                commit('loader/SET_9_OFF',null,root);
                if(response.length || response){
                    commit('ADD_IMAGES', response);
                }  
            });
            
        }

    },
    modules: {
        
    },
};