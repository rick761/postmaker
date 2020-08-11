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

//COMPONENT - order
Vue.component('delivery-component', require('./components/order/delivery.vue').default);


//COMPONENT - profile
Vue.component('edit-profile-component', require('./components/profile/editProfile').default)
Vue.component('portfolio-profile-component', require('./components/profile/portfolio').default)
Vue.component('preview-profile-component', require('./components/profile/preview').default)


//IMPORT MODULES
import router from './router';
import store from './store'


//START VUE
const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
    router,
    store
});