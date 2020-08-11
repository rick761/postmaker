import Vue from 'vue';
import Vuex from 'vuex';
import request from '../support/request'
import router from '../../router';
const root = {root:true};


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({       
        orders_open: [],
        orders_contentaanvrager: [],
        orders_postmaker: [],
        orders_requested:[],  
        orders_archive: []       
    }),
    getters: {        
        ORDERS_OPEN_COUNT:(state)=>{
            if(state.orders_open.length == 0){
                return '0';
            }   
            return state.orders_open.length;
        },
        ORDERS_PERSONAL_COUNT:(state,getters,rootState)=>{
            if(rootState.auth.user.type == "Postmaker"){
                if(state.orders_postmaker.length == 0){
                    return '0';
                }                
                return state.orders_postmaker.length; 
            }
            if(state.orders_contentaanvrager.length == 0){
                console.log('22')
                return '0';
            }
            return state.orders_contentaanvrager.length;       
        },
        ORDERS_REQUESTED_COUNT:(state)=>{
            if(state.orders_requested.length == 0){
                return '0';
            }         
            return state.orders_requested.length;
        }
    },
    mutations: {
        NEW_ORDER(state,payload){            
            state.orders_contentaanvrager.push(payload);            
        },
        CLEAR(state){
            state.orders_open=[];
            state.orders_contentaanvrager=[];
            state.orders_postmaker=[];
            state.orders_requested=[];
            state.orders_archive=[];
        }
    },
    actions: {

        update({ state }, payload) {            
            for (var index in state.orders) {
                if (state.orders[index].id == payload.id) {
                    state.orders[index] = payload;
                }
            }
        },        
        
        openOrders({dispatch,state}){
            dispatch('request/get', 'api/orders/open').then(()=>{ 
                var result = state.request.RESPONSE;
                if(result.orders_open){
                    state.orders_open = result.orders_open;
                }                            
            });
        },

        requestedOrders({dispatch,state}){
            dispatch('request/get', 'api/orders/requested').then(()=>{
                var result = state.request.RESPONSE;                                         
                if(result.orders_requested){
                    state.orders_requested = result.orders_requested;
                }                 
            }) 
        },

        myOrders({dispatch,state}){
            dispatch('request/get', 'api/orders/postmaker').then(()=>{ 
                var result = state.request.RESPONSE;               
                if(result.orders_postmaker){                    
                    state.orders_postmaker = result.orders_postmaker;
                }  
                            
            });                      
            dispatch('request/get', 'api/orders/contentaanvrager').then(()=>{                 
                var result = state.request.RESPONSE;                           
                if(result.orders_contentaanvrager){
                    state.orders_contentaanvrager = result.orders_contentaanvrager;
                }                                   
            })  
        },
        
        archivedOrders({dispatch,state}){
            dispatch('request/get', 'api/orders/archived').then(()=>{
                var result = state.request.RESPONSE;                                         
                if(result.orders_archived){                    
                    state.orders_archived = result.orders_archived;
                }                 
            }) 
        },

        get({dispatch,state}){   
                    
            dispatch('request/get', 'api/orders/open').then(()=>{ 
                var result = state.request.RESPONSE;
                if(result.orders_open){
                    state.orders_open = result.orders_open;
                }                            
            });

                     
            dispatch('request/get', 'api/orders/postmaker').then(()=>{ 
                var result = state.request.RESPONSE;               
                if(result.orders_postmaker){                    
                    state.orders_postmaker = result.orders_postmaker;
                }                              
            }); 
               
            dispatch('request/get', 'api/orders/contentaanvrager').then(()=>{                 
                var result = state.request.RESPONSE;                           
                if(result.orders_contentaanvrager){
                    state.orders_contentaanvrager = result.orders_contentaanvrager;
                }                                   
            })  

            dispatch('request/get', 'api/orders/requested').then(()=>{
                var result = state.request.RESPONSE;                                         
                if(result.orders_requested){
                    state.orders_requested = result.orders_requested;
                }                 
            }) 

            dispatch('request/get', 'api/orders/archived').then(()=>{
                var result = state.request.RESPONSE;                                         
                if(result.orders_archived){                    
                    state.orders_archived = result.orders_archived;
                }                 
            }) 
            
        },

        create({commit,state,dispatch}){            
            commit('loader/SET_3_ON',null,root);          
            dispatch('request/get', 'api/order/create').then(()=>{ 
                var response = state.request.RESPONSE;         
                if(response || response.length){
                    commit('NEW_ORDER',response); 
                    router.push('/order/'+response.id)      
                }
                commit('loader/SET_3_OFF',null,root);          
            }); 
        }
    },
    modules: {
        request
    },
};