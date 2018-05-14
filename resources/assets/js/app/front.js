import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import routes from './routes';

if('undefined' === typeof window.axios) {
    window.axios = require('axios');
}
// let token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }


const HOST = '/';



axios.defaults.baseURL = HOST;



const router = new VueRouter({
    base:'/',
    mode:'history',
    routes // （缩写）相当于 routes: routes
});

const app = new Vue({
    el: '#app',
    router
});

// 跳转后返回顶部
router.afterEach((to,from,next) => {
    window.scrollTo(0,0);
})
//
// window.go404 = 123;

// const NotFound = { template: '<p>Page not found</p>' }
// const Home = { template: '<p>home page</p>' }
// const About = { template: '<p>about page</p>' }
//
// const routes = {
//     '/': Home,
//     '/about': About
// }
//
// const router = new VueRouter({
//     routes // （缩写）相当于 routes: routes
// });
//
// const app = new Vue({
//     router
// }).$mount('#app');K