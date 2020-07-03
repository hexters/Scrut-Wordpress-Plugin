import Vue from 'vue';

import ScrutAdminReportIndex from './components/ScrutAdminReportIndex.vue';
import ScrutAdminReportDetail from './components/ScrutAdminReportDetail.vue';
import VueCarousel from '@chenfengyuan/vue-carousel';
import ScrutBalance from './components/ScrutBalance.vue';

Vue.component('vue-carousel', VueCarousel);

if(document.getElementById('scrut-admin-report')) {
  var vue = new Vue({
    el: '#scrut-admin-report',
    components: {
      ScrutAdminReportIndex,
      ScrutAdminReportDetail
    }
  });
}

if(document.getElementById('wp-admin-bar-scrut-balance')) {
  // Showing scrut balance in toolbar
  new Vue({
    el: '#wp-admin-bar-scrut-balance',
    components: {
      ScrutBalance
    }
  });
}