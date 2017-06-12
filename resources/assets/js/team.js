/**
 * Created by kaireewu on 2017/6/12.
 */
import Vue from 'vue'
import VueResource from 'vue-resource'

Vue.config.devtools = true
Vue.use(VueResource)

let token = document.querySelector('meta[name=csrf-token]')
if (token) {
  token = token.getAttribute('content')
}
if (token) {
  Vue.http.headers.common['X-CSRF-TOKEN'] = token
} else {
  let cookies = document.cookie.split(';')
  cookies.map((x) => {
    let cookie = x.split('=')
    if (cookie && cookie.length) {
      if (cookie[0].indexOf('XSRF-TOKEN') >= 0) {
        Vue.http.headers.common['X-XSRF-TOKEN'] = cookie[1].trim()
      }
    }
  })
}

const app = new Vue({
  el: '#quotaApp',
  components: {}
})
