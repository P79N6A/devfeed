import Vue from 'vue';
import Router from 'vue-router';
import SourceList from '../components/source/list.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  base: '/admin/source/',
  routes: [
    {
      path: '/',
      name: 'SourceList',
      component: SourceList,
    },
  ],
});
