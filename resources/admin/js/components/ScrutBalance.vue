<template>
  <span> 
    <span v-if="apikey">
      <img class="ab-icon" :src="icon" alt="Scrut Icon" style="width:20px;padding-top:8px;">
      Balance {{ balance }} cr
    </span>
  </span>
</template>
<script>

import axios from 'axios';

export default {
  props: ['email', 'apikey', 'icon'],
  data() {
    return {
      balance: '__'
    }
  },
  mounted() {
    this.fetchBalance();
  },
  methods: {
    fetchBalance() {
      axios.get(`${ajax_option.ajaxurl}?action=get_balance`)
        .then(json => {
          this.balance = json.data.balance;
        })
        .catch(error => console.log(error));
    }
  }
}
</script>