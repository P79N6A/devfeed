/**
 * Created by kaireewu on 2016/11/18.
 */
/* eslint no-new: 1 */

require('./bootstrap');

window.Vue = require('vue');

const quotaList = require('./views/quotaList.vue');
const siteList = require('./views/siteList.vue');

'use strict'

const app = new Vue({
  el: '#quotaApp',
  components: {
    quotaList,
    siteList
  }
})
