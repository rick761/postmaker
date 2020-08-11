//REQUEST FOR API CALL

import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)

const root = {root:true}

axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
axios.defaults.headers.common['Access-Control-Allow-Methods'] = 'GET, POST, PATCH, PUT, DELETE, OPTIONS';
axios.defaults.headers.common['Access-Control-Allow-Headers'] = 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers,X-Access-Token,XKey,Authorization';

export default {
    namespaced: true,
    strict: true,

    state: {
        errorLog:[],
        token: localStorage.getItem('user-token'),
        const: {
            base_url: localStorage.getItem('server-url')
        },
        RESPONSE: [],
        _func: {
            format_fix_data: (res) => {
                while (res.data != undefined) {
                    res = res.data;
                }
                return res;
            },
        }
    },

    mutations: {
        CLEAR_RESPONSE(state){
            state.RESPONSE = [];
        },
        SET_RESPONSE(state, payload) {
            state.RESPONSE = payload;
        },
        FORMAT_RESPONSE(state) {
            state.RESPONSE = state._func.format_fix_data(state.RESPONSE);
        },
        RELOAD_TOKEN(state){
            state.token = localStorage.getItem('user-token');
        },
        ADD_TO_ERRORLOG(state,error){
            state.errorLog.push(error);
            console.log(error);            
        }
    },

    actions: {

        // GET ACTION 
        async get({ state, commit, dispatch }, url) {
            commit('CLEAR_RESPONSE');
            commit('RELOAD_TOKEN');       
            var config = {                
                url: state.const.base_url + url,
                headers:{'Authorization': 'Bearer '+state.token},                
            }
            await axios(config).then(
                response => {           

                    if(response.data.errors){
                        dispatch('errors/set' , response.data.errors, root)                    
                    } 
                    if(!response.data.errors){
                        commit('SET_RESPONSE', response);
                        commit('FORMAT_RESPONSE');                  
                    } 

                },
                    error => {   
                        commit('ADD_TO_ERRORLOG',error)                        
                    }
                )
        },

        
        // POST ACTION 
        async post( { state, commit,dispatch }, payload) { 
            commit('CLEAR_RESPONSE');
            commit('RELOAD_TOKEN');     
            var config = {
                method: 'post',
                url: state.const.base_url + payload.url,
                headers:{'Authorization': 'Bearer '+state.token},
                data : payload.data
            }
                         
            await axios(config).then(            
                response => {

                    if(response.data.errors){
                        dispatch('errors/set' , response.data.errors, root)      
                                   
                    } 
                    
                    if(!response.data.errors){
                        commit('SET_RESPONSE', response);
                        commit('FORMAT_RESPONSE');                  
                    } 

                },
                error => {                     
                    commit('ADD_TO_ERRORLOG',error)                                            
                }
            );
        },

        // FILE UPLAOD 
        async file( { state, commit, dispatch }, payload) { 
            commit('CLEAR_RESPONSE');
            commit('RELOAD_TOKEN');                 

            var config = {
                method: 'post',
                url: state.const.base_url + payload.url,
                headers:{
                    'Authorization': 'Bearer ' + state.token,
                    'Content-Type': 'multipart/form-data'                
                },
                data : payload.data
            }        
                         
            await axios(config).then(            
                response => {                        
                    if(response.data.errors){
                        dispatch('errors/set' , response.data.errors, root)                    
                    } 
                    if(!response.data.errors){
                        commit('SET_RESPONSE', response);
                        commit('FORMAT_RESPONSE');                  
                    } 
                },
                error => {                     
                    commit('ADD_TO_ERRORLOG',error)                                            
                }
            );
            
        },

    },
}