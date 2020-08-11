import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list:[],
        _tmp:undefined,
        last_timer:0,
        
    }),
    mutations: {
        CLEAR_ERROR(state){
            state.list = [];       
        },

        REMOVE_INDEX(state,payload){
            state.list.splice(payload,1);            
        },

        ADD_ERROR(state,payload){              
            for(var i in payload){
                state.list.push({[i]:payload[i]});                
            }
            state._tmp =  payload ;
            while(state.list.length > 5){
                state.list.pop();
            }
        },
        CLEAR_TMP(state){
            state._tmp = undefined;   
        }

    },    
    actions:{

        set({state,commit},payload){            
            commit('ADD_ERROR',payload)    
            state.last_timer++;
            var current_timer = state.last_timer          
            setTimeout( function(){
                if(current_timer == state.last_timer) commit('CLEAR_TMP');
            }, 5000)                            
        },

        remove({commit},payload){
            commit('REMOVE_INDEX',payload);
        },
        
        clear({commit}){
            commit('CLEAR_ERROR');
        }
    },
    modules: {
        
    },
};