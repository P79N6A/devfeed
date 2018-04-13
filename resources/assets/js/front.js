import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import routes from './frontRoutes';

// Vue.component('side-menu', require('./components/app/sideMenu'));
// Vue.component('example', require('./components/example.vue'));



const router = new VueRouter({
    base:'/',
    mode:'history',
    routes // （缩写）相当于 routes: routes
});

const app = new Vue({
    el: '#app',
    router
});
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