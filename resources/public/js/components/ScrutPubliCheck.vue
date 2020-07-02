<template>
  <div class="scrut check-wrap">
    <form action="" method="post" v-on:submit.prevent="check()">
      <img :src="assets + '/images/logo.png'" alt="Scrut Logo" class="logo" width="150">
      <h3 class="title">
        Check Your <u>REAL</u> Car Condition
      </h3>
      <p><strong>Don't buy a car without knowing the <u>REAL</u> history!</strong></p>
      <div>
        <input type="text" name="chassis_no" v-model="chassisNo" id="chassis_no" style="width:100%;text-align:center;" placeholder="Type Japan VIN / chassis no. here" required>
      </div>
      <div class="action">
        <button type="submit" :disabled="checkLoading" style="text-align:center;">
          <img v-if="checkLoading" :src="`${assets}/images/loading-red-white.gif`" width="30" style="display:inline;">
          <span v-else>Check!</span>
        </button>
      </div>
    </form>

    <div v-if="error">
      <hr>
      <p>{{ error }}</p>
    </div>

    <div v-if="reports.length > 0">
      <hr>
      <div v-for="(item, index) in reports" :key="index">
        <h4>{{ item.chassis_no }}</h4>
        
        <table class="table-result">
          <tbody>
            <tr v-for="(list, i) in item.found" :key="i">
              <td width="25%">
                <img :src="list.image" width="200">
              </td>
              <td width="75%" style="text-align:left;">
                <strong>{{ list.model }}</strong>
                <div>{{ list.year }}</div>
                <div>{{ list.car_color }}</div>
                <div>{{ list.transmission }}</div>
                <div>{{ list.car_grade }}</div>
                <div>{{ list.status }}</div>
                <a v-if="list.status == 'available'" :href="`${item.buy_url}${list.key}`" target="_blank" class="button button-action button-buy" style="float:right;">Buy Report</a>
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    </div>

  </div>
</template>
<script>
import axios from 'axios';

export default {
  props: ['assets'],
  data() {
    return {
      chassisNo: '',
      checkLoading: false,
      reports: [],
      error: null
    }
  },
  methods: {
    check() {
      this.checkLoading = true;
      this.error = null;
      this.reports = [];
      axios.post(`${ajax_option.ajaxurl}?action=get_check`, {
        chassis_no: this.chassisNo
      })
      .then(json => {
        this.checkLoading = false;
        if(json.data.length > 0) {
          this.reports = json.data;
        } else {
          this.error = 'Chassis not found!';
        }
      })
      .catch(error => {
        this.checkLoading = false;
        let { message } = error.response.data;
        alert(message);
      });
    },
    buy(chassis_no, key) {
      window.open(`${ajax_option.ajaxurl}/topup?chassis_no=${chassis_no}&key=${key}`, '_blank');
    }
  }
}
</script>
<style lang="scss">
  .scrut {
    max-width: 580px;
    font-family: Arial, Helvetica, sans-serif;
    &.check-wrap {
      text-align: center;
    }
    .logo{
      display: inline;
    }
    .title {
      font-weight: bold;
      margin: 0;
    }
    .action {
      margin-top: 1em;
      button {
        width: 100%;
        background: #d2232a;
      }
    }
    .button-action{
      background: #d2232a;
    }
    .button-buy {
      padding: 5px 30px;
      font-size: 80%;
    }
    table.table-result{
      background: #ffffff;
    }

  }
  
</style>