import Vue from 'vue';
import { report } from './router';

var vue = new Vue({
  el: '#scrut-admin-report',
  router: report
});

// Showing scrut balance in toolbar
import ScrutBalance from './components/ScrutBalance.vue';
new Vue({
  el: '#wp-admin-bar-scrut-balance',
  components: {
    ScrutBalance
  }
});