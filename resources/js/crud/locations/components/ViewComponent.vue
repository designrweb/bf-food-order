<template>
  <div>
    <back-button-component :route="main_route"></back-button-component>
    <div class="card">
      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-title"></h3>
          </div>
          <div class="col-12 col-sm-4 action-buttons">
            <edit-button v-if="allowActions.edit && allowActions.all" :id="id"
                         :mainRoute="main_route"></edit-button>
            <delete-button v-if="allowActions.delete && allowActions.all" :id="id"
                           :mainRoute="main_route"></delete-button>
          </div>
        </div>

      </div>
      <div class="card-body">
        <div class="text-center" v-if="isPageBusy">
          <spinner-component></spinner-component>
        </div>
        <table class="table table-striped">
          <tbody>
          <tr v-for="(data, index) in pageData" v-bind:key="data.key">
            <th>{{ data.label }}</th>
            <td v-if="index === 'image_name'">
              <b-img v-if="data.value" rounded left :src="data.value" v-bind="{ width: 75, height: 75}" alt="Fluid image"></b-img>
            </td>
            <td v-else> {{ data.value }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import {EditButton, DeleteButton}  from "../../shared/grid-buttons";
import {getViewStructure, getItem} from "../../api/crudRequests";
import SpinnerComponent            from "../../shared/SpinnerComponent";
import BackButtonComponent         from "../../shared/BackButtonComponent";

export default {
  components: {
    'edit-button':           EditButton,
    'delete-button':         DeleteButton,
    'spinner-component':     SpinnerComponent,
    'back-button-component': BackButtonComponent,
  },
  props:      {
    main_route: String,
    id:         String | Number,
  },
  data() {
    return {
      isTableBusy:  false,
      isPageBusy:   false,
      itemData:     [],
      fields:       [],
      pageData:     {},
      allowActions: {
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
      let data          = await getViewStructure(this.main_route);
      this.fields       = data['data']['fields'];
      this.allowActions = data['data']['allowActions'];
      this.isPageBusy   = false;
    },
    async _loadData() {
      this.isPageBusy = true;
      let response    = await getItem(this.main_route, this.id);
      this.itemData   = response['data'];
      this.isPageBusy = false;
    },

    _preparePageData() {
      const self      = this;
      this.isPageBusy = true;

      for (const [key, value] of Object.entries(this.fields)) {
        self.pageData[value.key] = {
          'label': value.label,
          'value': ''
        };
        let fieldValue;
        value.key.split('.').forEach(function (item, index) {
          if (typeof fieldValue == "undefined") {
            fieldValue = self.itemData[item];
          } else {
            fieldValue = fieldValue[item];
          }
        });
        self.pageData[value.key]['value'] = fieldValue;
      }
      this.isPageBusy = false;
    }
  },
  async mounted() {
    await this._loadStructure();
    await this._loadData();
    this._preparePageData();
  },
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

.card-title {
  font-size: 1.75rem;
}

.action-buttons {
  text-align: right;
}

</style>
