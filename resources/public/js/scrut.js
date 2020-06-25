import Vue from 'vue';
window.scrutUrl = process.env.NODE_ENV === 'development' ? 'https://staging.scrut.my' : 'https://scrut.my';

Vue.component('scrut-public-listing', require('./components/ScrutPublicListing.vue').default);

var vue = new Vue({
  el: '#scrut-public-app'
});