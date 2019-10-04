import Vue from 'vue';
import Cookies from 'js-cookie';
import axios from 'axios';

Vue.use({
    install(vue) {
        vue.prototype.$cookies = Cookies;
        vue.$cookies = Cookies;
        const $axios = axios.create({
            baseURL: `${process.env.MIX_APP_URL}/api`,
        });
        $axios.interceptors.request.use( (config) => {
            config.headers['Content-Type'] = 'application/json';
            const token = Cookies.get("token");
            if (!!token) {
                config.headers['Token'] = token;
            }
            return config;
        });

        vue.prototype.$axios = $axios;
        vue.$axios = $axios;
    }
});

Vue.filter("capitalize", (str) => {
    if (!!str) {
        return str[0].toUpperCase() + str.substring(1);
    }
    return "";
});
