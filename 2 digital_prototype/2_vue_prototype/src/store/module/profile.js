import Vue from 'vue';
import Vuex from 'vuex';
import user from '../models/user'
import router from '../../router';
const root = {root:true}


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        user: [
           
        ]
    }),
    mutations: {},
    actions: {
        //getauth
        set({ rootState,commit,dispatch }, user_id ) {            
            if(user_id){
                commit('loader/SET_2_ON',null, root);         
                dispatch('request/get', 'api/user/'+user_id, root).then(()=>{                    
                    var user = rootState.request.RESPONSE;
                    console.log(user.id)
                    if(user.id != undefined){
                        dispatch('user/set',user)
                    }                    
                    if(!(user.id != undefined)){
                        router.push('/home')
                    }
                    commit('loader/SET_2_OFF',null,root)
                })
            }            
        },
    },
    modules: {
        user,
        
    },
};