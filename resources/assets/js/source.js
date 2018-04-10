'use strict';

require('./bootstrap');

import Vue from 'vue';

import router from './routes/source';

import SourceView from './views/source';

Vue.config.productionTip = false;

new Vue({
  el: '#sourceApp',
  router,
  template: '<source-view />',
  components: { SourceView }
});
