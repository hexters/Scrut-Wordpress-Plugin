<template>
  <div>
    <form action="" class="posts-filter">
      <p class="search-box">
        <label class="screen-reader-text" for="post-search-input">Search Chassis:</label>
        <input type="search" id="post-search-input" name="chassis" v-model="search">
        <input type="button" id="search-submit" class="button" value="Search Chassis">
      </p>
      <div style="clear:both;heigh:1em;padding:1em;"></div>
      <table class="wp-list-table widefat fixed striped posts">
        <thead>
          <tr>
            <td class="manage-column column-cb check-column">
              <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
              <input id="cb-select-all-1" type="checkbox">
            </td>
            <th>Chassis</th>
            <th style="text-align:right;">From</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="listFilter.length === 0 && !fetchLoading">
            <td colspan="3">No Report found</td>
          </tr>
          <tr v-if="fetchLoading">
            <td colspan="3">Fetching report...</td>
          </tr>
          <tr v-for="(item, i) in listFilter" :key="i">
            <th scope="row" class="check-column">
              <input id="cb-select-1" type="checkbox" name="post[]" value="1">
            </th>
            <td class="username column-username has-row-actions column-primary">
              <a :href="item.result[0].imgs[1]" :data-caption="item.chassis_no" data-fancybox="scrut-gallery">
                <img :src="item.result[0].imgs[1]" class="avatar avatar-32 photo" width="32" height="32">
              </a>
              <strong>
                <a @click="viewDetail(item)" href="javascript:void(0);">{{ item.chassis_no }}</a>
              </strong>
              <div class="row-actions">
                <span class="view">
                  <a @click="viewDetail(item)" href="javascript:void(0);">View</a>
                </span>
              </div>
            </td>
            <td  align="right">{{ item.from }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td class="manage-column column-cb check-column">
              <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
              <input id="cb-select-all-1" type="checkbox">
            </td>
            <th>Chassis</th>
            <th style="text-align:right;">From</th>
          </tr>
        </tfoot>
      </table>
    </form>
  </div>
</template>
<script>
import axios from 'axios';
export default {
  props: ['email', 'apikey'],
  data() {
    return {
      lists: [],
      fetchLoading: false,
      search: ''
    }
  },
  computed: {
    listFilter () {
      const search = this.search.toLowerCase().trim();
      if (!search) return this.lists;
      return this.lists.filter( c => {
        return c.chassis_no.toLowerCase().indexOf(search) > -1;
      });
    }
  },
  mounted() {
    this._fetchList();
  },
  methods: {
    viewDetail(item) {
      this.$router.push({ path: `/detail/${item.chassis_no}`, query: {
        result: JSON.stringify(item.result)
      } });
    },
    _fetchList() {
      this.fetchLoading = true;
      axios.post(`${ajax_option.ajaxurl}?action=get_report`, {
        email: this.email,
        key: this.apikey,
      })
      .then(json => {
        this.lists = json.data.data.reports;
        this.fetchLoading = false;
      })
      .catch(error => {
        console.log('error', error);
        
        this.fetchLoading = false;
      });
    }
  }
}
</script>