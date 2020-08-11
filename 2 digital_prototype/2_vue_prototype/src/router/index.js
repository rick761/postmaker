import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../views/home.vue';
import Order from '../views/order.vue';
import Open from '../views/open.vue';
import Requested from '../views/requested.vue';
import Account from '../views/account.vue';
import Archive from '../views/archive.vue';
import Landing from '../views/landing.vue';
import orderAanvrager from '../views/order/orderRequester';
import orderCreate from '../views/order/orderCreate';
import orderPostmaker from '../views/order/orderPostmaker';

Vue.use(VueRouter);

const routes = [{
        path: '/order/orderaanvrager',
        name: 'ordercreate',
        component: orderAanvrager,
    }, {
        path: '/order/ordercreate',
        name: 'orderaanvrager',
        component: orderCreate,
    }, {
        path: '/order/orderpostmaker',
        name: 'orderpostmaker',
        component: orderPostmaker,
    },
    {
        path: '/',
        name: 'landing',
        component: Landing,
    },
    {
        path: '/home',
        name: 'home',
        component: Home,
    },
    {
        path: '/open',
        name: 'open',
        component: Open,
    },
    {
        path: '/requested',
        name: 'requests',
        component: Requested,
    },
    {
        path: '/order/:id',
        name: 'order',
        component: Order,
    },
    {
        path: '/account',
        name: 'account',
        component: Account,
    },
    {
        path: '/account/:id',
        name: 'view profile',
        component: Account,
    },
    {
        path: '/archive',
        name: 'archive',
        component: Archive,
    },
];

const router = new VueRouter({
    routes,
});

export default router;