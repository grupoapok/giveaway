require('./bootstrap');

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import Admin from './admin/components/Admin';

import './plugins';
import './icons';
import router from './admin/router';
import store from './admin/store/index';

Vue.use(BootstrapVue);

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(Admin)
});
