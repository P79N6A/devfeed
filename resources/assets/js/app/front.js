import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';


import routes from './routes';

import stores from '../store/store.js';

Vue.use(VueRouter);


if('undefined' === typeof window.axios) {
    window.axios = require('axios');
}
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const HOST = '/';
axios.defaults.baseURL = HOST;


const router = new VueRouter({
    base:'/',
    mode:'history',
    routes // （缩写）相当于 routes: routes
});



axios.interceptors.request.use(function(config){
    stores.dispatch('showloader')
    return config
},function(err){
    return Promise.reject(err)
});
axios.interceptors.response.use(function(response){
    stores.dispatch('hideloader')
    return response
},function(err){
    return Promise.reject(err)
});


const app = new Vue({
    el: '#app',
    router,
    store:stores
});
// 跳转后返回顶部
router.afterEach((to,from,next) => {
    window.scrollTo(0,0);
});
