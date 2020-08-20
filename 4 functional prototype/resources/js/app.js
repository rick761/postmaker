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
Vue.component('previewImageComponent', require('./components/previewImageComponent.vue').default);
Vue.component('notificationComponent', require('./components/notificationComponent.vue').default);

//parts
Vue.component('card', require('./components/parts/card.vue').default);
Vue.component('modal', require('./components/parts/modal.vue').default);
Vue.component('global-modal', require('./components/parts/global_modal.vue').default);

//COMPONENT - auth
Vue.component('login-modal-component', require('./components/auth/loginModal.vue').default);
Vue.component('register-modal-component', require('./components/auth/registerModal.vue').default);

//COMPONENT - order_list
Vue.component('order-list-component', require('./components/order_list/list.vue').default);
Vue.component('order-list-item-component', require('./components/order_list/listItem.vue').default);
Vue.component('order-remove-list-item-component', require('./components/order_list/ListItem_remove.vue').default);
Vue.component('order-open-list-item-component', require('./components/order_list/ListItem_open.vue').default);
Vue.component('order-account-list-item-component', require('./components/order_list/ListItem_account.vue').default);
Vue.component('order-messages-list-item-component', require('./components/order_list/ListItem_messages.vue').default); // not used
Vue.component('order-state-list-item-component', require('./components/order_list/ListItem_state.vue').default);
Vue.component('order-request-confirm-list-item-component', require('./components/order_list/ListItem_request_confirm.vue').default);
Vue.component('order-request-apply-list-item-component', require('./components/order_list/ListItem_request_apply.vue').default);

/************************************************************************************************************************************************************ */
/************************************************************************************************************************************************************ */
//COMPONENT - order
/************************************************************************************************************************************************************ */
/************************************************************************************************************************************************************ */
Vue.component('order-aside-component', require('./components/order/aside.vue').default);
Vue.component('order-actions-component', require('./components/order/actions.vue').default);
Vue.component('order-chatbox-component', require('./components/order/chatbox.vue').default);


//COMPONENT - order-requests
Vue.component('order-request-order-component', require('./components/order/request/request_order.vue').default);
Vue.component('order-incoming-request-component', require('./components/order/request/incoming_request.vue').default);
Vue.component('order-accepted-request-component', require('./components/order/request/accepted_request.vue').default);

//COMPONENT - order-descriptions
Vue.component('create-order-descriptions-component', require('./components/order/description/create_descriptions').default);
Vue.component('order-info-component', require('./components/order/description/info.vue').default);
Vue.component('order-extra-description-component', require('./components/order/description/extra_description').default);

//COMPONENT - ORDER-FILES
Vue.component('create-files-component', require('./components/order/files/create_files').default);
Vue.component('order-files-moodboard-component', require('./components/order/files/moodboard').default);

//COMPONENT - ORDER-TAGS
Vue.component('create-tags-component', require('./components/order/tags/create_tags').default);

//COMPONENT - ORDER-Delivery
Vue.component('order-delivery-component', require('./components/order/delivery/delivery').default);
Vue.component('order-delivery-open-component', require('./components/order/delivery/delivery_open').default);
Vue.component('order-delivery-new-component', require('./components/order/delivery/delivery_new').default);
Vue.component('order-delivery-final-component', require('./components/order/delivery/delivery_final').default);
Vue.component('order-delivery-preview-component', require('./components/order/delivery/preview').default);
Vue.component('order-delivery-comments-component', require('./components/order/delivery/delivery_comments').default);

/************************************************************************************************************************************************************ */

//COMPONENT - profile
Vue.component('edit-profile-component', require('./components/profile/editProfile').default)
Vue.component('portfolio-profile-component', require('./components/profile/portfolio').default)
Vue.component('preview-profile-component', require('./components/profile/preview').default)


//IMPORT MODULES
import router from './router';
import store from './store';

const app = new Vue({
    vuetify: new Vuetify({
        rtl: getReverseMode(),
        theme: {
            dark: getDarkTheme(),
            themes: getTheme(),
        }
    }),
    el: '#app',
    router,
    store
});



function getTheme() {
    /* https://material.io/design/color/the-color-system.html#tools-for-picking-colors */

    var theme = {
        primary: '#bf3300', // menu color - primary button
        complementary: '#008cbf', //accent        
        analogous_1: '#00a069', //success
        analogous_2: '#bf3300', //link color        
        triadic_1: '#da0000', //error
        triadic_2: '#ff6e3d', //warning
        bg_card: '#fff',
        bg: '#ECEFF1',
        bg_menu: '#008cbf' // menu color -
    };

    if ((localStorage.getItem('theme') == 'default_theme')) {
        theme = {
            primary: '#1976D2', // menu color - primary button
            complementary: '#82B1FF', //accent        
            analogous_1: '#4CAF50', //success
            analogous_2: '#2196F3', //link color        
            triadic_1: '#FF5252', //error
            triadic_2: '#FFC107', //warning
            bg_card: '#fff',
            bg: '#E0E0E0',
            bg_menu: '#1976D2' // menu color -
        };
    }
    if ((localStorage.getItem('theme') == 'basil')) {
        theme = {
            primary: '#356859', // menu color - primary button
            complementary: '#FD5523', //accent   
            analogous_2: '#B9E4C9', //link color  
            analogous_1: '#3C7968', //success
            triadic_1: '#FF5722', //error
            triadic_2: '#FF5722', //warning
            bg_card: '#F1F5DF',
            bg: '#FFFBE6',
            bg_menu: '#356859' // menu color -
        };
    }
    if ((localStorage.getItem('theme') == 'crane')) {
        theme = {
            primary: '#5D1049', // menu color - primary button
            complementary: '#E30425', //accent    
            analogous_1: '#67C95A', //success
            analogous_2: '#720D5D', //link color  
            triadic_1: '#E30425', //error
            triadic_2: '#FD9726', //warning
            bg_card: '#fff',
            bg: '#F0CCE2',
            bg_menu: '#5D1049' // menu color -
        };
    }
    if ((localStorage.getItem('theme') == 'fortnightly')) {
        theme = {
            primary: '#c2c2c2', // menu color - primary button
            complementary: '#8355FB', //accent    
            analogous_1: '#1DCF62', //success
            analogous_2: '#000000', //link color  
            triadic_1: '#F78CB3', //error
            triadic_2: '#F78CB3', //warning
            bg_card: '#fff',
            bg: '#fff',
            bg_menu: '#c2c2c2' // menu color -
        };
    }
    if ((localStorage.getItem('theme') == 'owl')) {
        theme = {
            primary: '#0336FF', // menu color - primary button
            complementary: '#FF0266', //accent    
            analogous_1: '#00CFCA', //success
            analogous_2: '#FF0266', //link color  
            triadic_1: '#FF0266', //error
            triadic_2: '#EF3C2C', //warning
            bg_card: '#fff',
            bg: '#FFDE03',
            bg_menu: '#0336FF' // menu color -
        };
    }
    if ((localStorage.getItem('theme') == 'rally')) {
        theme = {
            primary: '#33333D', //primary button
            complementary: '#FFFFFF', //accent    
            analogous_1: '#37EFBA', //success
            analogous_2: '#1EB980', //link color  
            triadic_1: '#FF6859', //error
            triadic_2: '#FFAC12', //warning
            bg_card: '#33333D',
            bg: '#33333D',
            bg_menu: '#72DEFF' // menu color -#
        };
    }
    if ((localStorage.getItem('theme') == 'reply')) {
        theme = {
            primary: '#FAAB1A', // menu color - primary button
            complementary: '#FAAB1A', //accent    
            analogous_1: '#191919', //success
            analogous_2: '#6200EE', //link color  
            triadic_1: '#191919', //error
            triadic_2: '#191919', //warning
            bg_card: '#FEFEFE',
            bg: '#EDF0F2',
            bg_menu: '#344A55'
        };
    }
    if ((localStorage.getItem('theme') == 'shrine')) {
        theme = {
            primary: '#FEDBD0', // menu color - primary button
            complementary: '#2D2D2D', //accent    
            analogous_1: '#0336FF', //success
            analogous_2: '#000000', //link color  
            triadic_1: '#FF3645', //error
            triadic_2: '#FEDBD0', //warning
            bg_card: '#FFFFFF',
            bg: '#FFF0E8',
            bg_menu: '#FFDBCF'
        };
    }

    return {
        dark: {
            // primary: theme.complementary, // primary variant
            // secondary: theme.analogous_2, //secondary variant
            // accent: theme.analogous_2, // primary variant
            // error: theme.triadic_1,
            // info: theme.analogous_2, //secondary variant
            // success: theme.analogous_1, //secondary 
            // warning: theme.triadic_2, //
            // anchor: theme.primary, // primary variant
            // //beegees
            // background: theme.bg,
            // background_menu: theme.bg_menu, //colors.deepPurple.accent3,
            // background_card: theme.bg_card,
        },
        light: {
            primary: theme.complementary, // primary variant
            secondary: theme.analogous_2, //secondary variant
            accent: theme.analogous_2, // primary variant
            error: theme.triadic_1,
            info: theme.analogous_2, //secondary variant
            success: theme.analogous_1, //secondary 
            warning: theme.triadic_2, //
            anchor: theme.primary, // primary variant
            //beegees
            background: theme.bg,
            background_menu: theme.bg_menu, //colors.deepPurple.accent3,
            background_card: theme.bg_card,
        }
    }
}


function getDarkTheme() {
    return (localStorage.getItem('dark-theme') == 'true');
}

function getReverseMode() {
    return (localStorage.getItem('reverse-mode') == 'true');
}