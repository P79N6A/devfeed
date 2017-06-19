require('./bootstrap');

import Vue from 'vue';

const quotaList = require('./views/quotaList.vue');
const siteList = require('./views/siteList.vue');

window.bus = new Vue();

const app = new Vue({
  el: '#quotaApp',
  components: {
    quotaList,
    siteList
  }
})
