import Vue from 'vue'
import Vuex from 'vuex'

//store modules
import auth from './modules/auth'
import api from './modules/api-call'
import file from './modules/file-upload'
import image from './modules/preview-image'
import order from './modules/order'
import orders from './modules/orders'
import user from './modules/user'
import modal from './modules/global-modal'
import notifications from './modules/notifications'
import loader from './modules/loader'


Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'develop'

export default new Vuex.Store({
    modules: {
        auth,
        api,
        file,
        image,
        order,
        orders,
        user,
        modal,
        notifications,
        loader
    },
    strict: debug
})