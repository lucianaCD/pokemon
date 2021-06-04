/**
 Este es mi Router
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import router from './router/index';
import App from './App.vue';

Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router,
    components: { App }
});
