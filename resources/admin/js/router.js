import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ScrutAdminReportIndex from './components/ScrutAdminReportIndex.vue';
import ScrutAdminReportDetail from './components/ScrutAdminReportDetail.vue';

export const report = new VueRouter({
  mode: 'hash',
  routes: [
    { path: '/', component: ScrutAdminReportIndex },
    { path: '/detail/:id', component: ScrutAdminReportDetail }
  ]
});