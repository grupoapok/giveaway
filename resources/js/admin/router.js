import Vue from 'vue';
import VueRouter from 'vue-router';
import Cookies from "js-cookie";

Vue.use(VueRouter);

const requireRoutes = require.context("./features", true, /routes\.js$/);
const childRoutes = [];

requireRoutes.keys().forEach(fileName => {
    if (fileName.indexOf("routes.js") !== -1) {
        childRoutes.push({ ...requireRoutes(fileName).default });
    }
});



const router = new VueRouter({
    linkExactActiveClass: "active",
    linkActiveClass: "active",
    routes: [
        {
            path: '/',
            name: 'Login',
            component: () => import(/* webpackChunkName: "js/login" */ "./components/LoginComponent")
        },
        {
            path: "/admin",
            name: "Home",
            component: () => import(/* webpackChunkName: "admin-layout" */ "./components/AdminLayout"),
            meta: { requiresAuth: true },
            children: [
                {
                    path: "/dashboard",
                    name: "Dashboard",
                    component: () => import(/* webpackChunkName: "not-found" */ "./views/Dashboard")
                },
                ...childRoutes,
                {
                    path: "*",
                    component: () => import(/* webpackChunkName: "not-found" */ "./views/NotFoundPage")
                }
            ],
            beforeEnter: (to, from, next) => {
                if (!Cookies.get("session_token")) {
                    next({name: 'Login'});
                    return;
                }
                next();
            },
        }
    ]
});

export default router;
