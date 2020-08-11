import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import api from './modules/api-call'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'develop'

export default new Vuex.Store({
    modules: {
        auth,
        api
    },
    strict: debug
})