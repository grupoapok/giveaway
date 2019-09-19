import Vue from 'vue';
import Cookies from 'js-cookie';
import axios from 'axios';

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
