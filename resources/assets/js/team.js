require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);


const index = require('./views/teamList.vue');

const routes = [
  { path: '/', component: index }
]

const router = new VueRouter({
  routes
})

const app = new Vue({
  el: '#teamApp',
  router
})
