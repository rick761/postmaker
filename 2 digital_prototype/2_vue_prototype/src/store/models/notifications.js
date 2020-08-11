import Vue from 'vue';
import Vuex from 'vuex';
import Pusher from 'pusher-js';
import {PUSHER_APP_KEY,PUSHER_APP_CLUSTER} from '../../assets/constants'

const root = {root:true};

Vue.use(Vuex);

// Enable pusher logging - don't include this in production

//Pusher.logToConsole = true;
const pusher = new Pusher(PUSHER_APP_KEY, 
{
    cluster: PUSHER_APP_CLUSTER,
    authEndpoint: `${localStorage.getItem('server-url')}api/broadcasting/auth`,
    auth: {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    }
  }
);


export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        list: []
    }),
    
    mutations: {
      SET_NOTIFICATIONS(state,payload){        
        for(var i in payload){
          state.list.push(payload[i]);          
        }
      },
      SET_NOTIFICATION(state,payload){        
        state.list.unshift(payload);        
      },
      SET_READ(state,payload){
          state.list.filter(item => item.id == payload.id)[0].read =1;          
      }

    },
    getters:{
      UNREAD_NOTIFICATIONS(state){        
        return state.list.filter(item => item.read == 0).length;
      }
    },
    actions: {

      init({commit,dispatch,rootState}){               
          // var authUserid = rootState.auth.user.id;

          pusher.subscribe(`notification-channel`).bind('new-notification', function(data) {            
              if(rootState.auth.user.id == data.notification.user_id){
                commit('SET_NOTIFICATION', data.notification);
                
              }
          });
          
          dispatch('request/get','api/notifications/get',root).then(()=>{
              var response = rootState.request.RESPONSE; 
              commit('SET_NOTIFICATIONS',response );       
                  
          });
      },

      read({commit,dispatch},payload){        
        commit('SET_READ',payload);
        dispatch('request/post',{ url:'api/notifications/read', data:payload },root);
        
      }

    },
    modules: {

    },
};