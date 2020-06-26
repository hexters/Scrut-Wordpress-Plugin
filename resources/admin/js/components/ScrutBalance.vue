<template>
  <span> 
    <span v-if="apikey">
      <img class="ab-icon" :src="icon" alt="Scrut Icon" style="width:20px;padding-top:8px;">
      Balance RM 500
    </span>
  </span>
</template>
<script>
export default {
  props: ['email', 'apikey', 'icon']
}
</script>