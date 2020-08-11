//MODULES
require('./bootstrap');
window.Vue = require('vue');
import Vuetify from 'vuetify';
Vue.use(Vuetify);


//COMPONENTS - page
Vue.component('vue-app', require('./App.vue').default);
Vue.component('drawer-component', require('./components/DrawerComponent.vue').default);
Vue.component('landing-component', require('./components/LandingComponent.vue').default);
Vue.component('breadcrumbComponent', require('./components/breadCrumbComponent.vue').default);
Vue.component('modal', require('./components/modal.vue').default);
Vue.component('previewImageComponent', require('./components/previewImageComponent.vue').default);

//COMPONENT - auth
Vue.component('login-modal-component', require('./components/auth/loginModal.vue').default);
Vue.component('register-modal-component', require('./components/auth/registerModal.vue').default);

//COMPONENT - order_list
Vue.component('order-list-component', require('./components/order_list/list.vue').default);
Vue.component('order-list-item-component', require('./components/order_list/listItem.vue').default);
Vue.component('order-remove-list-item-component', require('./components/order_list/ListItem_remove.vue').default);
Vue.component('order-account-list-item-component', require('./components/order_list/ListItem_account.vue').default);
Vue.component('order-messages-list-item-component', require('./components/order_list/ListItem_messages.vue').default);
Vue.component('order-state-list-item-component', require('./components/order_list/ListItem_state.vue').default);
Vue.component('order-request-confirm-list-item-component', require('./components/order_list/ListItem_request_confirm.vue').default);
Vue.component('order-request-apply-list-item-component', require('./components/order_list/ListItem_request_apply.vue').default);

/************************************************************************************************************************************************************ */
/************************************************************************************************************************************************************ */
//COMPONENT - order
/************************************************************************************************************************************************************ */
/************************************************************************************************************************************************************ */
Vue.component('order-delivery-component', require('./components/order/delivery.vue').default);
Vue.component('order-aside-component', require('./components/order/aside.vue').default);

//COMPONENT - order-requests
Vue.component('order-request-order-component', require('./components/order/request/request_order.vue').default);
Vue.component('order-incoming-request-component', require('./components/order/request/incoming_request.vue').default);

//COMPONENT - order-descriptions
Vue.component('create-order-descriptions-component', require('./components/order/description/create_descriptions').default);

//COMPONENT - ORDER-FILES
Vue.component('create-files-component', require('./components/order/files/create_files').default);
Vue.component('order-files-moodboard-component', require('./components/order/files/moodboard').default);

//COMPONENT - ORDER-TAGS
Vue.component('create-tags-component', require('./components/order/tags/create_tags').default);

/************************************************************************************************************************************************************ */

//COMPONENT - profile
Vue.component('edit-profile-component', require('./components/profile/editProfile').default)
Vue.component('portfolio-profile-component', require('./components/profile/portfolio').default)
Vue.component('preview-profile-component', require('./components/profile/preview').default)


// import { preset } from 'vue-cli-plugin-vuetify-preset-basil/preset';

// import (`vue-cli-plugin-vuetify-preset-${localStorage.getItem('theme')}/preset`).then(obj => {
//     console.log('obj', obj)
// }).catch(err => {
//     console.log('err', err)
// });

//IMPORT MODULES
import router from './router';
import store from './store';
import { preset as basil } from 'vue-cli-plugin-vuetify-preset-crane/preset';
import { preset as crane } from 'vue-cli-plugin-vuetify-preset-crane/preset';
import { preset as owl } from 'vue-cli-plugin-vuetify-preset-owl/preset';
import { preset as rally } from 'vue-cli-plugin-vuetify-preset-rally/preset';
import { preset as reply } from 'vue-cli-plugin-vuetify-preset-reply/preset';
import { preset as shrine } from 'vue-cli-plugin-vuetify-preset-shrine/preset';
import { preset as default_theme } from './store/constants';



const app = new Vue({
    vuetify: new Vuetify({
        preset: getTheme(),
        rtl: getReverseMode(),
        theme: getDarkTheme(),
    }),
    el: '#app',
    router,
    store
});

function getTheme() {
    var theme = localStorage.getItem('theme');
    var toReturn;
    switch (theme) {
        case 'basil':
            toReturn = basil;
            break;
        case 'crane':
            toReturn = crane;
            break;
        case 'owl':
            toReturn = owl;
            break;
        case 'rally':
            toReturn = rally;
            break;
        case 'reply':
            toReturn = reply;
            break;
        case 'shrine':
            toReturn = shrine;
            break;
        default:
            toReturn = default_theme;
            break;
    }
    return toReturn;
}

function getDarkTheme() {
    var dark = (localStorage.getItem('dark-theme') == 'true');

    if (dark) {
        return { dark: true };
    }

    if (!dark) {
        return { dark: false };
    }

}

function getReverseMode() {
    var reverse = (localStorage.getItem('reverse-mode') == 'true');

    if (reverse) {
        return true;
    }

    if (!reverse) {
        return false;
    }

}