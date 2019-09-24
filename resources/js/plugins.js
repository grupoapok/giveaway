import Vue from 'vue';
import Cookies from 'js-cookie';
import axios from 'axios';

Vue.use({
    install(vue) {
        vue.prototype.$cookies = Cookies;
        vue.$cookies = Cookies;
        const $axios = axios.create({
            baseURL: `${process.env.MIX_APP_URL}/api`,
            headers: {
                'Content-Type': 'application/json',
                'Token': (() => Cookies.get('token'))()
            },
        });
        vue.prototype.$axios = $axios;
        vue.$axios = $axios;
    }
});

Vue.filter("capitalize", (str) => {
    if (str !== null && str !== "") {
        return str[0].toUpperCase() + str.substring(1);
    }
    return "";
});
