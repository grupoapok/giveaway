import Vue from 'vue';
import VueRouter from 'vue-router';
import Cookies from "js-cookie";

import Page1 from './components/Page1Component';
import Page2 from './components/Page2Component';
import Page2Extra from './components/Page2ExtraComponent';

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
                    return;
                }
                next();
            }
        },
        {
            path: '/step2',
            components: {
                default: Page2,
                extra: Page2Extra
            },
            beforeEnter: (to, from, next) => {
                if (!Cookies.get("token")) {
                    next('/step1');
                    return;
                }
                next();
            }
        }
    ]
});

export default router;
