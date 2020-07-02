<template>
  <div>
    <h3>Chassis No {{ chassis_no }}</h3>

    <div class="loading" v-if="loading">
      <img :src="`${assets}/images/loading-red.gif`" width="20" style="float:left;margin-right:.3rem;"> Loading...
    </div>
    <div class="error" v-if="error">
      <p>{{ error }}</p>
    </div>
    <div v-for="(item, i) in results" :key="i" style="margin-top:1em;">
      <table class="wp-list-table widefat fixed striped posts">
        <tbody>
            <tr>
              <td></td>
              <td></td>
              <td rowspan="20">
                <div style="max-height:650px;overflow:auto;text-align:center;">
                  <a :data-caption="item.result.lot_number" data-fancybox="scrut-gallery" v-for="(img, index) in item.imgs" :key="index" :href="img">
                    <img :src="img" width="250">
                  </a>
                </div>
                <br>
                <p style="padding-left:20px;">* Scroll down to view all image</p>
              </td>
            </tr>
            <tr>
              <td><strong>LOT NUMBER</strong></td>
              <td>{{ item.result.lot_number }}</td>
            </tr>
            <tr>
              <td><strong>AUCTION</strong></td>
              <td>{{ item.result.auction }}</td>
            </tr>
            <tr>
              <td><strong>AUCTION DATE</strong></td>
              <td>{{ item.result.auction_date }}</td>
            </tr>
            <tr>
              <td><strong>CHASSIS ID</strong></td>
              <td>{{ item.result.chassis_ID }}</td>
            </tr>
            <tr>
              <td><strong>MAKE</strong></td>
              <td>{{ item.result.vendor }}</td>
            </tr>
            <tr>
              <td><strong>MODEL</strong></td>
              <td>{{ item.result.model }}</td>
            </tr>
            <tr>
              <td><strong>MILEAGE</strong></td>
              <td>{{ item.result.mileage }}</td>
            </tr>
            <tr>
              <td><strong>ENGINE CC</strong></td>
              <td>{{ item.result.engine_CC }}</td>
            </tr>
            <tr>
              <td><strong>YEAR</strong></td>
              <td>{{ item.result.year }}</td>
            </tr>
            <tr>
              <td><strong>SPECS</strong></td>
              <td>{{ item.result.grade }}</td>
            </tr>
            <tr>
              <td><strong>DATABASE RECORDED</strong></td>
              <td>{{ item.result.inspection }}</td>
            </tr>
            <tr>
              <td><strong>EQUIPMENT</strong></td>
              <td>{{ item.result.equipment }}</td>
            </tr>
            <tr>
              <td><strong>TRANSMISSION</strong></td>
              <td>{{ item.result.transmission }}</td>
            </tr>
            <tr>
              <td><strong>AWD</strong></td>
              <td>{{ item.result.awd }}</td>
            </tr>
            <tr>
              <td><strong>START PRICE</strong></td>
              <td>{{ item.result.start_price }}</td>
            </tr>
            <tr>
              <td><strong>FINISH PRICE</strong></td>
              <td>{{ item.result.finish_price }}</td>
            </tr>
            <tr>
              <td><strong>COLOR</strong></td>
              <td>{{ item.result.color }}</td>
            </tr>
            <tr>
              <td><strong>GRADE</strong></td>
              <td>{{ item.result.condition }}</td>
            </tr>
            <tr>
              <td><strong>STATUS</strong></td>
              <td>{{ item.result.status }}</td>
            </tr>
            <tr>
              <td><strong>CHASSIS</strong></td>
              <td>{{ item.result.chassis }}</td>
            </tr>
          </tbody>
        </table>
      
    </div>
  </div>
</template>
<script>
import axios from 'axios';

export default {
  props: ['report', 'assets'],
  data() {
    return {
      loading: false,
      results: [],
      chassis_no: null,
      error: null
    }
  },
  mounted() {
    this.fetchDetail();
  },
  methods: {
    fetchDetail() {
      this.loading = true;
      axios.post(`${ajax_option.ajaxurl}?action=get_view`, {
        report_id: this.report
      }).then(json => {
        if(json.data.status == 1) {
          this.chassis_no = json.data.data.chassis_no;
          this.results = json.data.data.result;
        } else {
          this.error = json.data.message;
        }
        this.loading = false;
      }).catch(error => {
        let { message } = error.response.data;
        alert(message);
        this.loading = false;
      });
    }
  }
}
</script>