import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ScrutPubliCheck from './components/ScrutPubliCheck.vue';

export const routeCheck = new VueRouter({
  base: 'scrut-check',
  mode: 'hash',
  routes: [
    { path: '/', component: ScrutPubliCheck },
    { path: '/detail', component: ScrutPubliCheck },
  ]
});