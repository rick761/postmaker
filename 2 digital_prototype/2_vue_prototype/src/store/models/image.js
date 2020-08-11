import Vue from 'vue';
import Vuex from 'vuex';
const root = {root:true};


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({        
        list:[]        
    }),
    mutations: {
        SET_IMAGES: function(state,payload){
            state.list = payload;
        },
        ADD_IMAGE: function (state,payload){
            state.list.push(payload)
        },
        ADD_IMAGES: function (state,payload){
            for(var i in payload)
                state.list.push(payload[i])
        },
        DEL_IMAGE_BY_ID(state, payload) {            
            for(var i in state.list){                
                if(state.list[i].id == payload){
                    state.list.splice(i,1);
                }
            }            
        },
    },
    actions: {

        set({commit},payload){
            commit('SET_IMAGES',payload);
        },

        upload({commit,dispatch,rootState},payload){
            payload.append('order_id', rootState.order_page.order.id);   
            commit('loader/SET_3_ON',null,root);
            dispatch( 'request/file', {url:'api/order/image/upload', data:payload }, root ).then( () => {
                var response = rootState.request.RESPONSE;                   
                if(response.length || response){
                    commit('ADD_IMAGES', response);
                }
                commit('loader/SET_3_OFF',null,root);
            });      

        },

        delete({ commit,dispatch,rootState }, payload) {                
            commit('loader/SET_3_ON',null,root);                
            dispatch('request/post', { url:'api/order/image/delete', data: {'id': payload} },root).then(()=>{
                var response = rootState.request.RESPONSE;                
                if(response.length || response){
                    commit('DEL_IMAGE_BY_ID',payload);
                }  
                commit('loader/SET_3_OFF',null,root);  
            });            
        },
    },
    modules: {


    },
};