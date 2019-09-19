import Vue from 'vue';
import VueRouter from 'vue-router';
import Cookies from "js-cookie";

import Page1 from './components/Page1Component';
import Page2 from './components/Page2Component';

Vue.use(VueRouter);

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

export default router;
