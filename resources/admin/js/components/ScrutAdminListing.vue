<template>
  <div>
    <h4>Admin Listing</h4>
    <p>{{ email }}</p>
    <p>{{ apikey }}</p>
  </div>
</template>
<script>
import axios from 'axios';
export default {
  props: ['email', 'apikey'],
  mounted() {
    this._fetchList();
  },
  methods: {
    _fetchList() {
      axios.get(`${scrutUrl}/api/list`, {
        params: {
          email: this.email,
          key: this.apikey
        }
      })
      .then(json => {
        console.log(json);
      })
      .catch(error => console.log(error));
    }
  }
}
</script>