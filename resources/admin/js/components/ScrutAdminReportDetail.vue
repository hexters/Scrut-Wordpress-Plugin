<template>
  <div>
    <button @click="backPage()" style="float:left;" class="button">&larr; Back</button>
    <h3 style="float:left;margin-top:5px;margin-left:1em;">Shassis No {{ $route.params.id }}</h3>
    

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

export default {
  data() {
    return {
      results: []
    }
  },
  mounted() {
    let { result } = this.$route.query;
    this.results = result ? JSON.parse(result) : [];
  },
  methods: {
    backPage() {
      this.$router.go(-1);
    },
    openImage(e, images) {
      
    }
  }
}
</script>