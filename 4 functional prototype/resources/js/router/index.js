//load
import Vue from 'vue';
import VueRouter from 'vue-router';

//postmaker
import order_postmaker from '../views/postmaker/order';
import Requested_postmaker from '../views/postmaker/requested';
import Home_postmaker from '../views/postmaker/home';

//requester
import Home_requester from '../views/requester/home';
import Requested_requester from '../views/requester/requested';
import order_requester from '../views/requester/order/default';
import order_edit from '../views/requester/order/edit';

//general
import index from '../views/index';
import openOrder from '../views/openOrder';
import Archive from '../views/archive';
import Open from '../views/open';
import profile from '../views/profile';
import account from '../views/account';
import settings from '../views/settings';
import archivedOrder from '../views/archivedOrder';
import adminPanel from '../views/admin'


Vue.use(VueRouter);

const routes = [
    /* general */

    {
        path: '/admin/panel',
        name: 'Admin panel',
        component: adminPanel,
    },
    {
        path: '/',
        name: 'Home',
        component: index,
    },
    {
        path: '/archive',
        name: 'Archief',
        component: Archive,
    },
    {
        path: '/open',
        name: 'Openbaar',
        component: Open,
    },



    {
        path: '/order/open/:orderId',
        name: 'Beschikbare opdracht',
        component: openOrder,
    },
    {
        path: '/archive/order/:orderId',
        name: 'Beschikbare opdracht',
        component: archivedOrder,
    },
    {
        path: '/profile',
        name: 'Profiel',
        component: profile,
    },
    {
        path: '/account/:user_id',
        name: 'Account',
        component: account
    },
    {
        path: '/settings',
        name: 'Instellingen',
        component: settings,
    },


    /**postmaker**/
    {
        path: '/postmaker/order/:orderId',
        name: 'Opdracht',
        component: order_postmaker,
    },
    {
        path: '/postmaker/requested',
        name: 'Uitgaande aangevragen',
        component: Requested_postmaker,
    },
    {
        path: '/postmaker/orders',
        name: 'Opdrachten',
        component: Home_postmaker,
    },


    /*requester */
    {
        path: '/requester/orders',
        name: 'Opdrachten',
        component: Home_requester,
    },
    {
        path: '/requester/order/new',
        name: 'Opdracht maken',
        component: order_edit,
    },
    {
        path: '/requester/order/edit/:orderId',
        name: 'Opdracht aanpassen',
        component: order_edit,
    },
    {
        path: '/requester/order/:orderId',
        name: 'Opdracht',
        component: order_requester,
    },
    {
        path: '/requester/requested',
        name: 'Binnenkomende aanvragen',
        component: Requested_requester,
    },
    {
        path: '/profile',
        name: 'Profiel',
        component: profile,
    },


];

const router = new VueRouter({
    routes,
});

router.beforeEach((to, from, next) => {
    localStorage.setItem('last_route_name', from.name);
    localStorage.setItem('last_route_path', from.path);
    next();
});

export default router;