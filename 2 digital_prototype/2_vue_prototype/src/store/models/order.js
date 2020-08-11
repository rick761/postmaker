import Vue from 'vue';
import Vuex from 'vuex';
import comments from './comment'
import images from './image'
import messages from './message'
import requests from './request'
import deliverys from './delivery'

const root = {root:true};



Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden

    state: () => ({
        id: null,
        title: null,
        description: null,  
        user: { id: 0, },
        postmaker: { id: 0, },
        payment: null,
        date_start: null,
        deliver: null,
        state: null,
        postmaker_state: null,        
    }),

    mutations: {
        SET_ID(state, payload) {
            state.id = payload;
        },
        SET_TITLE(state, payload) {
            state.title = payload;
        },
        SET_DESCRIPTION(state, payload) {
            state.description = payload;
        },        
        SET_USER(state, payload) {
            state.user = payload;
        },
        SET_POSTMAKER(state, payload) {
            state.postmaker = payload;
        },
        SET_PAYMENT(state, payload) {
            state.payment = payload;
        },
        SET_DATE_START(state, payload) {
            state.date_start = payload;
        },
        SET_DELIVER(state, payload) {
            state.deliver = payload;
        },
        SET_STATE(state, payload) {
            state.state = payload;
        },
        SET_POSTMAKER_STATE(state, payload) {
            state.postmaker_state = payload;
        },        

        CLEAR(state) {            
            state.id = null;
            state.title = null;
            state.description = null;           
            state.user = { id: '' },
            state.postmaker = { id: null },
            state.payment = null;
            state.date_start = null;
            state.deliver = null;
            state.state = null;
            state.postmaker_state = null;            
        },
    },
    actions: {
        
        reset({ commit }) {
            commit('CLEAR');
        },

        save({state,dispatch,commit }, payload){            
            payload.id = state.id;
            commit('loader/SET_5_ON',null,root);         
            dispatch('request/post', { url:'api/order/save', data : payload }, root).then(()=>{                
                commit('loader/SET_5_OFF',null,root);                    
            });            
        },

        changeState({dispatch,state,rootState},payload){
            var _tmp = payload;            
            payload =  {state: _tmp, id: state.id};                     
            dispatch('request/post', { url:'api/order/setState', data : payload }, root).then(()=>{
                var response = rootState.request.RESPONSE;                    
                if(response.length || response){
                    dispatch('set',{ state: payload.state });
                }                
            });           
        },

        changePostmakerState({dispatch,state,rootState},payload){
            var _tmp = payload;            
            payload =  {postmaker_state: _tmp, id: state.id};          
            dispatch('request/post', { url:'api/order/setPostmakerState', data : payload }, root).then(()=>{
                var response = rootState.request.RESPONSE; 
                if(response.length || response){
                    dispatch('set',{ postmaker_state: payload.postmaker_state });
                }                          
            });
                  
        },


        set({ commit, dispatch }, payload) {                  
            
            if (payload.id) {
                commit('SET_ID', payload.id);
            }
            if (payload.title) {
                commit('SET_TITLE', payload.title);
            }            
            if (payload.description) {
                commit('SET_DESCRIPTION', payload.description);
            }            
            if (payload.user) {
                commit('SET_USER', payload.user);
            }
            if (payload.postmaker) {
                commit('SET_POSTMAKER', payload.postmaker);
            }
            if (payload.payment) {
                commit('SET_PAYMENT', payload.payment);
            }
            if (payload.created_at) {
                commit('SET_DATE_START', payload.created_at);
            }
            if (payload.deliver) {
                commit('SET_DELIVER', payload.deliver);
            }
            if (payload.state) {
                commit('SET_STATE', payload.state);
            }
            if (payload.postmaker_state) {
                commit('SET_POSTMAKER_STATE', payload.postmaker_state);
            }  

            //modules
            if (payload.images) {
                dispatch('images/set',payload.images);
            }
            if (payload.comments) {                                 
                dispatch('comments/set',payload.comments)
            }  
            if (payload.messages) {                                 
                dispatch('messages/set',payload.messages)
            }  
            if (payload.requests) {                                 
                dispatch('requests/set',payload.requests)
            } 
            if (payload.deliverys) {                                 
                dispatch('deliverys/set',payload.deliverys)
            }      
        },

    },
    modules: {        
        comments,
        images,
        messages,
        requests,
        deliverys
    },
};