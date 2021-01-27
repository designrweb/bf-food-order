<template>
  <div class="card">
    <div class="card-header" v-if="!isPageBusy">
      <h3 class="card-title">{{ title }}</h3>
      <create-button v-if="allowActions.create && allowActions.all" :mainRoute="main_route"></create-button>
    </div>
    <div class="card-body">
      <div class="card-header bg-light">
        <div class="float-right">
          <pagination-into-component :firstItem="firstItem" :lastItems="lastItems" :totalItems="totalItems"></pagination-into-component>
        </div>
      </div>
      <div class="text-center" v-if="isPageBusy">
        <spinner-component></spinner-component>
      </div>
      <b-table
          v-if="!isPageBusy"
          id="index-list"
          :items="items"
          :fields="fields"
          show-empty
          :busy="isTableBusy"
          responsive="sm">
        <template #empty="scope">
          <no-data-component></no-data-component>
        </template>
        <template v-slot:head()="scope">
          <div class="text-nowrap">
            <div v-if="sort.hasOwnProperty(scope.column)" class="sortable"
                 @click="changeSort(scope.column)">
              {{ scope.label }}
              <b-icon icon="sort-down" v-if="sort[scope.column] == 'desc'" font-scale="1.5"></b-icon>
              <b-icon icon="sort-down-alt" v-else-if="sort[scope.column] == 'asc'" font-scale="1.5"></b-icon>
            </div>
            <div v-else>{{ scope.label }}</div>
          </div>
        </template>
        <template v-slot:cell()="data">
          <div v-if="data.field.key ==='actions'" class="d-flex">
            <view-button v-if="allowActions.view" :mainRoute="main_route"
                         :id="data.item.id"></view-button>
            <edit-button v-if="allowActions.edit" :mainRoute="main_route"
                         :id="data.item.id"></edit-button>
            <delete-button v-if="allowActions.delete" :mainRoute="main_route"
                           :id="data.item.id"></delete-button>
          </div>
          <div v-else-if="data.field.key ==='image_name'">
            <b-img v-if="data.value" rounded :src="data.value" v-bind="{ width: 75, height: 75}" alt="Fluid image"></b-img>
          </div>
          <div v-else>
            {{ data.value }}
          </div>
        </template>
        <template v-slot:table-busy>
          <div class="text-center">
            <spinner-component></spinner-component>
          </div>
        </template>
      </b-table>
      <b-row>
        <b-col cols="10">
          <b-pagination
              @change="onPaginationChange"
              v-model="currentPage"
              :total-rows="totalItems"
              :per-page="perPage"
          ></b-pagination>
        </b-col>
        <b-col cols="2">
          <b-form-select v-model="itemsPerPage" :options="itemsPerPageOptions"></b-form-select>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import FilterTextInput                                      from "../../shared/filters/TextFilterComponent";
import {CreateButton, ViewButton, EditButton, DeleteButton} from "../../shared/grid-buttons";
import {getStructure, getItems}                             from "../../api/crudRequests";
import SpinnerComponent                                     from "../../shared/SpinnerComponent";
import PaginationInfoComponent                              from "../../shared/PaginationInfoComponent";
import NoDataComponent                                      from "../../shared/NoDataComponent";

export default {
  components: {
    'filter-text':               FilterTextInput,
    'create-button':             CreateButton,
    'view-button':               ViewButton,
    'edit-button':               EditButton,
    'delete-button':             DeleteButton,
    'spinner-component':         SpinnerComponent,
    'pagination-into-component': PaginationInfoComponent,
    'no-data-component':         NoDataComponent
  },
  props:      {
    main_route: String,
    title: String
  },
  data() {
    return {
      currentPage:         1,
      perPage:             1,
      totalItems:          0,
      firstItem:           0,
      lastItems:           0,
      isTableBusy:         false,
      isPageBusy:          false,
      items:               [],
      fields:              [],
      filters:             {},
      sort:                {},
      itemsPerPage:        10,
      itemsPerPageOptions: [
        {value: 10, text: 10},
        {value: 20, text: 20},
        {value: 50, text: 50},
        {value: 100, text: 100},
      ],
      allowActions:        {
        all:    true,
        create: true,
        view:   true,
        edit:   true,
        delete: true,
      }
    }
  },
  methods:    {
    async _loadStructure() {
      this.isPageBusy   = true;
      let data          = await getStructure(this.main_route);
      this.fields       = data['data']['fields'];
      this.filters      = data['data']['filters'];
      this.sort         = data['data']['sort'];
      this.allowActions = data['data']['allowActions'];
      this._addActionColumn();
      this.isPageBusy = false;
    },
    _addActionColumn() {
      if (this.allowActions.all)
        this.fields.push({
          key:   'actions',
          label: 'Actions',
        });
    },
    async _loadData(page = 1) {
      this.isTableBusy = true;
      let response     = await getItems(this.main_route, page, this.itemsPerPage, this.filters, this.sort);
      this.items       = response['data']['data'];
      this.currentPage = response['data']['pagination']['current_page'];
      this.perPage     = response['data']['pagination']['per_page'];
      this.totalItems  = response['data']['pagination']['total'];
      this.firstItem   = response['data']['pagination']['first_item'];
      this.lastItems   = response['data']['pagination']['last_item'];
      this.isTableBusy = false;
    },
    async applyFilter(filteredData) {
      for (let prop in filteredData) {
        this.filters[prop] = filteredData[prop];
      }
      await this._loadData(1);
    },
    async changeSort(column) {
      const self = this;
      // break for not sortable columns
      if (!self.sort.hasOwnProperty(column)) return;
      // break if table is busy
      if (self.isTableBusy) return;

      switch (self.sort[column]) {
        case 'asc':
          self.sort[column] = 'desc';
          break;
        case 'desc':
          self.sort[column] = '';
          break;
        default:
          self.sort[column] = 'asc';
          break;
      }
      await this._loadData(1);
    },
    async onPaginationChange(page) {
      await this._loadData(page);
    }
  },
  async mounted() {
    await this._loadStructure();
    await this._loadData(1);
  },
  watch:      {
    itemsPerPage: function (val) {
      this._loadData(1);
    }
  }
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
