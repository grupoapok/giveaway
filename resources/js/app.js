require('wc-spinners/dist/moon-spinner');
require('./bootstrap');

import Vue from 'vue';

import './plugins.js';
import './icons.js';
import router from './router';
import store from './store';

import Main from './components/Main';

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(Main)
});
