require('wc-spinners/dist/moon-spinner');
require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import Cookies from 'js-cookie';
import App from './App';
import Page1 from './Page1Component';
import Page2 from './Page2Component';

Vue.use({
    install(vue) {
        vue.prototype.$cookies = Cookies;
        vue.prototype.$axios = axios.create({
            baseURL: `${process.env.MIX_APP_URL}/api`,
            headers: {
                'Content-Type': 'application/json',
                'Token': (() => Cookies.get('token'))()
            },
        })
    }
});

Vue.use(VueRouter);
Vue.use(Vuex);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Page1,
            alias: '/step1',
            beforeEnter: (to, from, next) => {
                if (Cookies.get("token")) {
                    next('/step2');
                }
                next();
            }
        },
        {
            path: '/step2',
            component: Page2,
            beforeEnter: (to, from, next) => {
                if (!Cookies.get("token")) {
                    next('/step1');
                }
                next();
            }
        }
    ]
});

const store = new Vuex.Store({
    state: {
        name: '',
        email: '',
        tickets: 0,
        alignRight: false
    },
    mutations: {
        alignRight(state, val){
            state.alignRight = val;
        },
        updateUserInfo(state, payload) {
            if (payload) {
                if (payload.name) {
                    state.name = payload.name;
                }
                if (payload.email) {
                    state.email = payload.email;
                }
                if (payload.tickets) {
                    state.tickets = parseInt(payload.tickets, 10);
                }
            }
        },
        updateTickets(state, n){
            state.tickets = parseInt(n, 10);
        }
    },
    actions: {
        updateTickets(context, n) {
            context.commit('updateTickets', n);
        },
        updateUserInfo(context, payload) {
            context.commit('updateUserInfo', payload)
        },
        alignElementsToRight(context) {
            context.commit('alignRight', true);
        },
        alignElementsToLeft(context) {
            context.commit('alignRight', false);
        }
    }
});

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});