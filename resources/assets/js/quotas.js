/**
 * Created by kaireewu on 2016/11/18.
 */
/* eslint no-new: 1 */
import Vue from 'vue'
import VueResource from 'vue-resource'
import quotaList from './views/quotaList.vue'

Vue.config.devtools = true
Vue.use(VueResource)

new Vue({
  el: '#quotaApp',
  components: {
    quotaList
  }
})
