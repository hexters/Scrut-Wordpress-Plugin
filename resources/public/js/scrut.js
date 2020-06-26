import Vue from 'vue';

Vue.component('scrut-public-listing', require('./components/ScrutPublicListing.vue').default);

var vue = new Vue({
  el: '#scrut-public-app'
});

// Showing scrut balance in toolbar
import ScrutBalance from '../../admin/js/components/ScrutBalance.vue';
new Vue({
  el: '#wp-admin-bar-scrut-balance',
  components: {
    ScrutBalance
  }
});