import Vue from 'vue';

Vue.component('scrut-public-listing', require('./components/ScrutPublicListing.vue').default);

var vue = new Vue({
  el: '#scrut-public-app'
});