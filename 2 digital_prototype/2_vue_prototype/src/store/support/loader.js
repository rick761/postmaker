import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);

export default {
    namespaced: true,
    strict: true, //Alleen op false zetten als de data in deze module vanuit de component gemanipuleerd mag worden
    state: () => ({
        skeleton: false,
        loader1: false,
        loader2: false,
        loader3: false,
        loader4: false,
        loader5: false,
        loader6: false,
        loader7: false,
        loader8: false,
        loader9: false,        
    }),
    mutations: {
        SET_0_ON(state){ // for whole page
            state.skeleton=true;
        },
        SET_0_OFF(state){
            state.skeleton=false;
        },
        SET_1_ON(state){
            state.loader1=true;
        },
        SET_1_OFF(state){
            state.loader1=false;
        },
        SET_2_ON(state){
            state.loader2=true;
        },
        SET_2_OFF(state){
            state.loader2=false;
        },
        SET_3_ON(state){
            state.loader3=true;
        },
        SET_3_OFF(state){
            state.loader3=false;
        },
        SET_4_ON(state){
            state.loader4=true;
        },
        SET_4_OFF(state){
            state.loader4=false;
        },
        SET_5_ON(state){
            state.loader5=true;
        },
        SET_5_OFF(state){
            state.loader5=false;
        },
        SET_6_ON(state){
            state.loader6=true;
        },
        SET_6_OFF(state){
            state.loader6=false;
        },
        SET_7_ON(state){
            state.loader7=true;
        },
        SET_7_OFF(state){
            state.loader7=false;
        },
        SET_8_ON(state){
            state.loader8=true;
        },
        SET_8_OFF(state){
            state.loader8=false;
        },
        SET_9_ON(state){
            state.loader9=true;
        },
        SET_9_OFF(state){
            state.loader9=false;
        },        
    },
    actions: {               
    },
    modules: {
    },
};