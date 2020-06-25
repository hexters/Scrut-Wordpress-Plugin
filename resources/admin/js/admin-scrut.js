import Vue from 'vue';

Vue.component('scrut-admin-listing', require('./components/ScrutAdminListing.vue').default);

var vue = new Vue({
  el: '#scrut-admin-app'
});