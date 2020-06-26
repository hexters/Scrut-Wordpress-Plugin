import Vue from 'vue';
window.scrutUrl = process.env.NODE_ENV === 'development' ? 'https://staging.scrut.my' : 'https://scrut.my';

Vue.component('scrut-admin-listing', require('./components/ScrutAdminListing.vue').default);

var vue = new Vue({
  el: '#scrut-admin-app'
});

// Showing scrut balance in toolbar
import ScrutBalance from './components/ScrutBalance.vue';
new Vue({
  el: '#wp-admin-bar-scrut-balance',
  components: {
    ScrutBalance
  }
});