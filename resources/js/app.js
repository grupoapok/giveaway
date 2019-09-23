require('wc-spinners/dist/moon-spinner');
require('./bootstrap');

import 'bootstrap/js/dist/modal';
import 'bootstrap/js/dist/tooltip';

import Vue from 'vue';

import './plugins.js';
import './icons.js';
import router from './router';
import store from './store';

import Main from './components/Main';

$.get("https://ipinfo.io", function(response) {
    console.log(response.ip, response.country);
}, "jsonp");

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(Main)
});
