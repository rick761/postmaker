import Vue from 'vue';
import Vuex from 'vuex';

const root = {root:true}
Vue.use(Vuex);




export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden

    state: () => ({        
        token:          localStorage.getItem('user-token'),          
        server_url :    localStorage.getItem('server-url'),  
        public_path :   localStorage.getItem('server-public-path'),    

    }),

    mutations: {
        LOAD_CONSTANTS : function(state){
            /*
                Example row:
                storage.setItem(keyName, keyValue);  -- this.keyname = keyValue;
            */            
            localStorage.setItem('server-url', 'http://localhost:8000/');        state.server_url = 'http://localhost:8000/';
        },

        LOAD_SERVER_PUBLIC_FOLDER:function(state,payload){            
            var toSet = payload.replace(/\\/g, "/");
            localStorage.setItem('server-public-path', toSet ); state.public_path = payload;
        }
    },
    actions: {
        load({commit,rootState,dispatch}){
            commit('LOAD_CONSTANTS'); 

            //get file path
            dispatch('request/get','api/public_path',root).then(()=>{                
                commit('LOAD_SERVER_PUBLIC_FOLDER',rootState.request.RESPONSE); 
            });
                     
        }
        
    },
    modules: {

    },
};