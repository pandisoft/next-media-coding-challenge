/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('nm-product-list', require('./components/product/List').default);
Vue.component('nm-preloader', require('./components/Preloader').default);
Vue.component('nm-empty-state', require('./components/EmptyState').default);

Vue.prototype.$baseURL = window.frontend.base_url

const app = new Vue({
    el: '#nmapp',
});
