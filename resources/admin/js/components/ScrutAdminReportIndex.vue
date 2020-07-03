<template>
  <div>
    <form action class="posts-filter">
      <p class="search-box">
        <label class="screen-reader-text" for="post-search-input">Search Chassis:</label>
        <input type="search" id="post-search-input" name="chassis" v-model="search" />
        <input type="button" id="search-submit" class="button" value="Search Chassis" />
      </p>
      <div style="clear:both;heigh:1em;padding:1em;"></div>
      <table class="wp-list-table widefat fixed striped posts">
        <thead>
          <tr>
            <td style="text-align:center;" width="20%"></td>
            <th>Chassis</th>
            <th>Result</th>
            <th style="text-align:right;">From</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="listFilter.length === 0 && !fetchLoading">
            <td colspan="4">No Report found</td>
          </tr>
          <tr v-if="fetchLoading">
            <td colspan="4">
              <img
                :src="`${assets}/images/spinner-2x.gif`"
                width="20"
                style="float:left;margin-right:.3rem;"
              /> Loading...
            </td>
          </tr>
          <tr v-for="(item, i) in listFilter" :key="i">
            <td>
              <vue-carousel :data="images(item.result)" :controls="false" :indicators="false" />
            </td>
            <td class="username column-username has-row-actions column-primary">
              <strong>
                <a @click="viewDetail(item)" href="javascript:void(0);">{{ item.chassis_no }}</a>
              </strong>
              <div class="row-actions">
                <span class="view">
                  <a @click="viewDetail(item)" href="javascript:void(0);">View</a>
                </span>
              </div>
            </td>
            <td>{{ item.result.length }} Report</td>
            <td align="right">{{ item.from }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <th>Chassis</th>
            <th>Result</th>
            <th style="text-align:right;">From</th>
          </tr>
        </tfoot>
      </table>
    </form>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["assets"],
  data() {
    return {
      lists: [],
      fetchLoading: false,
      search: ""
    };
  },
  computed: {
    listFilter() {
      const search = this.search.toLowerCase().trim();
      if (!search) return this.lists;
      return this.lists.filter(c => {
        return c.chassis_no.toLowerCase().indexOf(search) > -1;
      });
    }
  },
  mounted() {
    this._fetchList();
  },
  methods: {
    images(item) {
      let images = Array.from(item);
      return images.map(result =>
        result.imgs.map((img, i) => {
          if (i == 0) return;
          return `<img src="${img}" width="50" />`;
        }).join(" ")
      );
    },
    viewDetail(item) {
      let detail = `${window.location.href}&detail=${item.report_id}`;
      window.open(detail, "_self");
    },
    _fetchList() {
      this.fetchLoading = true;
      axios
        .post(`${ajax_option.ajaxurl}?action=get_report`, {
          email: this.email,
          key: this.apikey
        })
        .then(json => {
          this.lists = json.data.data.reports;
          this.fetchLoading = false;
        })
        .catch(error => {
          let { message } = error.response.data;
          alert(message);
          this.fetchLoading = false;
        });
    }
  }
};
</script>