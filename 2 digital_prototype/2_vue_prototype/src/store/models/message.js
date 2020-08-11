import Vue from 'vue';
import Vuex from 'vuex';
const root = {root:true};


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: [
        ]
    }),
    mutations: {
        SET_MESSAGES(state,payload){ 
            state.list = payload;            
        },
        ADD_MESSAGE_ROW(state,payload) {            
            state.list.push(payload);
        },
    },
    actions: {

        set({ commit }, payload){
            commit('SET_MESSAGES', payload);            
        },      

        new({commit,rootState,dispatch},payload) {
            
            var order_id = rootState.order_page.order.id;            
            commit('loader/SET_6_ON',null,root);

            dispatch('request/post', { url:'api/order/message/new', data: {'order_id': order_id, text: payload } },root).then(()=>{
                var response = rootState.request.RESPONSE; 
                commit('loader/SET_6_OFF',null,root);                                
                if(response.length || response){                    
                    commit('ADD_MESSAGE_ROW',response);
                }
            });            
        }

    },
    modules: {

    },
};