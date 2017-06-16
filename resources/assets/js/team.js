'use strict';

require('./bootstrap');

import Vue from 'vue';

import VueRouter from 'vue-router';

Vue.use(VueRouter);

const teamView = require('./views/team.vue');

const routes = [
  { path: '/admin/team', component: teamView }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

window.bus = new Vue();

const app = new Vue({
  el: '#teamApp',
  router,
  methods: {
    addTeam() {
      bus.$emit('addTeam');
    }
  }
})
