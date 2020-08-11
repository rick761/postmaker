import Vue from 'vue';
import Vuex from 'vuex';
const root = {root:true};

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list:[

        ]
    }),
    mutations: {
        DEL_COMMENT_BY_ID(state, payload) {            
            for(var i in state.list){                
                if(state.list[i].id == payload){
                    state.list.splice(i,1);
                }
            }            
        },     
        SET_COMMENTS(state,payload){ 
            state.list = payload;            
        },
        ADD_COMMENT_ROW(state,payload) {            
            state.list.push(payload);
        },
        UPDATE_COMMENT(state,payload){            
            for(var i in state.list){                
                if(state.list[i].id === payload.item.id){
                    state.list[i][payload.field] = payload.value;                    
                }                
            }
        }

    },
    actions: {
        new({ commit,rootState,dispatch }) {
            var order_id = rootState.order_page.order.id;            
            commit('loader/SET_4_ON',null,root);

            dispatch('request/post', { url:'api/order/comment/new', data: {'order_id': order_id} },root).then(()=>{
                var response = rootState.request.RESPONSE; 
                commit('loader/SET_4_OFF',null,root);  
            
                if(response.length || response){
                    commit('ADD_COMMENT_ROW',response);
                }
            });            
        },

        delete({ commit,dispatch,rootState }, payload) {                
            commit('loader/SET_4_ON',null,root);    

            dispatch('request/post', { url:'api/order/comment/delete', data: {'id': payload} },root).then(()=>{
                var response = rootState.request.RESPONSE;
                
                if(response.length || response){
                    commit('DEL_COMMENT_BY_ID',payload);
                }  
                
                commit('loader/SET_4_OFF',null,root);  
            });            
        },

        update({ commit,dispatch }, payload){ 
                       
            commit('UPDATE_COMMENT', payload);
            commit('loader/SET_4_ON',null,root); 

            dispatch('request/post', {
                 url:'api/order/comment/update', 
                 data: {
                      'id': payload.item.id,
                      'field': payload.field,
                      'value': payload.value
                    } 
            },root).then(()=>{
                commit('loader/SET_4_OFF',null,root); 
            })
        },
         

        set({ commit }, payload){
            commit('SET_COMMENTS', payload);            
        }

    },
};



