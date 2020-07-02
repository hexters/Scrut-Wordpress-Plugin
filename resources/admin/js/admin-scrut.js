import Vue from 'vue';

import ScrutAdminReportIndex from './components/ScrutAdminReportIndex.vue';
import ScrutAdminReportDetail from './components/ScrutAdminReportDetail.vue';

var vue = new Vue({
  el: '#scrut-admin-report',
  components: {
    ScrutAdminReportIndex,
    ScrutAdminReportDetail
  }
});

// Showing scrut balance in toolbar
import ScrutBalance from './components/ScrutBalance.vue';
new Vue({
  el: '#wp-admin-bar-scrut-balance',
  components: {
    ScrutBalance
  }
});