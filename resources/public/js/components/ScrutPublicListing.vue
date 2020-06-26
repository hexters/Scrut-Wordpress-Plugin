<template>
  <div>
    <h4>Listing Public</h4>
    <p>{{ email }}</p>
    <p>{{ apikey }}</p>
  </div>
</template>
<script>
export default {
  props: ['email', 'apikey'],
  mounted() {
    console.log(ajax_option);
    
  }
}
</script>