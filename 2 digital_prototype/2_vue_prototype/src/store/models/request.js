import Vue from 'vue';
import Vuex from 'vuex';
const root = {root:true};

//REQUEST FOR ORDER

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        apply: "",
        incoming: []
    }),

    mutations: {

        CLEAR_APPLY(state){
            state.apply = ""  
        },

        SET_APPLY(state, payload) {  
            state.apply = payload            
        },

        SET_INCOMING(state,payload){
            state.incoming = payload;
        },            
    },

    actions: {

        set({ commit, rootState }, payload) {
            //incoming applys
            commit('SET_INCOMING',payload)

            //apply
            var hasFound= false;
            
            for(var i in payload){
                if(payload[i].postmaker_id == rootState.auth.user.id){ 
                    commit('SET_APPLY',payload[i])                       
                    hasFound= true;
                }
            }                
            
            if(!hasFound){
                commit('CLEAR_APPLY');
            }              
            
        },

        put({ rootState,commit,dispatch }, payload) {  
            var order_id = rootState.order_page.order.id;
            commit('loader/SET_7_ON',null,root);
            dispatch('request/post', { url:'api/order/request/put', data: {'order_id': order_id, text: payload } },root).then(()=>{
                var response = rootState.request.RESPONSE; 
                commit('loader/SET_7_OFF',null,root);  
                if(response.length || response){
                    commit('SET_APPLY', response);
                                                 
                }

            });
        },

        accept({commit,dispatch,rootState}, payload){
            commit('loader/SET_8_ON',null,root);
            var order_id = rootState.order_page.order.id;
            dispatch('request/post', { url:'api/order/request/accept', data: {'order_id': order_id, id: payload.id, postmaker_id:payload.postmaker_id  } },root).then(()=>{
                var response = rootState.request.RESPONSE;                          

                if(response.length || response){
                    commit('SET_INCOMING', response);  
                    if(response.status == 'accepted'){
                        dispatch('order_page/load',response.order_id, root) ;       
                    }    
                }
                commit('loader/SET_8_OFF',null,root);   
            });
        },

        decline({commit,dispatch,rootState}, payload){
            commit('loader/SET_8_ON',null,root);
            var order_id = rootState.order_page.order.id;
            dispatch('request/post', { url:'api/order/request/decline', data: {'order_id': order_id, id: payload.id } },root).then(()=>{
                var response = rootState.request.RESPONSE; 
                commit('loader/SET_8_OFF',null,root);    
                if(response.length || response){
                    commit('SET_INCOMING', response);                                                   
                }
            });
        },
        
        del({commit,dispatch,rootState}){
            commit('loader/SET_8_ON',null,root);
            var order_id = rootState.order_page.order.id;
            dispatch('request/post', { url:'api/order/request/delete', data: {'order_id': order_id } },root).then(()=>{
                var response = rootState.request.RESPONSE; 
                console.log(response);                
                commit('loader/SET_8_OFF',null,root);    
                if(response.length || response){
                    commit('CLEAR_APPLY');                                                   
                }
            });
        }

    },
    modules: {

    },
};