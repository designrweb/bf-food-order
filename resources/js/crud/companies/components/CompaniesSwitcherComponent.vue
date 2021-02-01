<template>
  <div>
    <b-dropdown split split-variant="outline-success" variant="success" :text="selected_company.name" class="m-3">
      <b-dropdown-item href="#" v-for="company in companies_list" :key="company.id">
        <span @click="switchCompany(company.id)">{{ company.name }}</span>
      </b-dropdown-item>
    </b-dropdown>
  </div>
</template>

<script>


import {switchCompany} from "../../api/crudRequests";

export default {
  components: {},
  props:      {
    main_route:       String,
    companies_list:   Array,
    selected_company: Array | Object,
  },

  data() {
    return {
      isBusy:    false,
      companies: [],
      mainProps: {width: 120, height: 20, class: 'm1'}
    }
  },
  methods: {
    async switchCompany(companyId) {
      let response = await switchCompany(this.main_route + '/' + companyId + '/switch-company');
      console.log(response);
      location.reload();
    }
  },
  async mounted() {
  },
  watch: {}
}
</script>

<style lang="scss">
@import './node_modules/bootstrap/scss/bootstrap.scss';
@import './node_modules/bootstrap-vue/src/index.scss';

.sortable {
  color: #3490dc;
  cursor: pointer;
}

.sortable:hover {
  color: #3caedc;
}
</style>
