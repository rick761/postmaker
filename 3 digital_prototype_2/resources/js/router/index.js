//load
import Vue from 'vue';
import VueRouter from 'vue-router';

//postmaker
import order_postmaker from '../views/postmaker/order'
import Requested_postmaker from '../views/postmaker/requested'
import Home_postmaker from '../views/postmaker/home';

//requester
import Home_requester from '../views/requester/home';
import Requested_requester from '../views/requester/requested'
import order_requester from '../views/requester/order/default'
import order_edit from '../views/requester/order/edit'

//general
import index from '../views/index'
import openOrder from '../views/openOrder'
import Inspire from '../views/inspire'
import Archive from '../views/archive';
import Open from '../views/open'
import profile from '../views/profile'


Vue.use(VueRouter);

const routes = [
    /* general */
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
        path: '/inspire',
        name: 'Inspiratie',
        component: Inspire,
    },

    {
        path: '/openOrder',
        name: 'Openbare order',
        component: openOrder,
    },
    {
        path: '/profile',
        name: 'Profiel',
        component: profile,
    },



    /**postmaker**/
    {
        path: '/postmaker/order',
        name: 'Order',
        component: order_postmaker,
    },
    {
        path: '/postmaker/requested',
        name: 'Aanvragen',
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
        name: 'Opdracht aanpassen',
        component: order_edit,
    },
    {
        path: '/requester/order',
        name: 'Opdracht',
        component: order_requester,
    },
    {
        path: '/requester/requested',
        name: 'Aanvragen',
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

export default router;