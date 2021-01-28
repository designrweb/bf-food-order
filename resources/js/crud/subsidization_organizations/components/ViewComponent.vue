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
          <tr v-for="data in pageData" v-bind:key="data.key">
            <th>{{ data.label }}</th>
            <td> {{ data.value }}</td>
          </tr>
          </tbody>
        </table>
      </div>

      <div class="card-footer">
        <div class="card">
          <div class="card-header">
            <h4 class="card-sub-title">Subventionsbericht</h4>
          </div>

          <div class="card-body">
            <div class="text-center" v-if="isReportBusy">
              <spinner-component></spinner-component>
            </div>

            <b-form @submit="onSubmit" @reset="onReset" v-if="!isReportBusy">
              <b-form-group
                  id="input-group-pre-order-report-start-date"
                  label="Startdatum"
                  label-for="input-pre-order-report-start-date"
              >
                <b-form-datepicker
                    id="input-pre-order-report-start-date"
                    v-model="form.start_date"
                    reset-button
                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                    locale="de"
                ></b-form-datepicker>
                <b-form-invalid-feedback :state="validation['start_date']['state']">
                  {{ validation['start_date']['message'] }}
                </b-form-invalid-feedback>
              </b-form-group>

              <b-form-group
                  id="input-group-pre-order-report-end-date"
                  label="Enddatum"
                  label-for="input-pre-order-report-end-date"
              >
                <b-form-datepicker
                    id="input-pre-order-report-end-date"
                    v-model="form.end_date"
                    reset-button
                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                    locale="de"
                ></b-form-datepicker>
                <b-form-invalid-feedback :state="validation['end_date']['state']">
                  {{ validation['end_date']['message'] }}
                </b-form-invalid-feedback>
              </b-form-group>

              <b-form-group
                  id="input-group-report_type_id"
                  label="Berichtstyp"
                  label-for="input-report_type_id"
              >
                <b-form-select
                    v-model="form.report_type"
                    :options="reportTypes"
                    class="mb-3 sl-report-type"
                ></b-form-select>
                <b-form-invalid-feedback :state="validation['report_type']['state']">
                  {{ validation['report_type']['message'] }}
                </b-form-invalid-feedback>
              </b-form-group>

              <b-button type="submit" variant="primary">Bericht generieren</b-button>

            </b-form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {EditButton, DeleteButton}         from "../../shared/grid-buttons";
import {getViewStructure, getItem, store} from "../../api/crudRequests";
import SpinnerComponent                   from "../../shared/SpinnerComponent";
import BackButtonComponent                from "../../shared/BackButtonComponent";
import {reportCall}                       from "../../api/exportRequest";

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
      isReportBusy: false,
      itemData:     [],
      fields:       [],
      pageData:     {},
      allowActions: {
        all:    true,
        create: true,
        view:   true,
        edit:   true,
        delete: true,
      },
      reportTypes:  [
        {value: null, text: 'Bitte wählen Sie einen Berichtstyp', disabled: true},
        {value: 1, text: 'Vorbestellter Subventionsbericht'},
        {value: 2, text: 'Pos bestellter Subventionsbericht'},
      ],
      form:         {
        report_type: null
      },
      validation:   {
        'id':          {'state': true, 'message': ''},
        'start_date':  {'state': true, 'message': ''},
        'end_date':    {'state': true, 'message': ''},
        'report_type': {'state': true, 'message': ''},
      },
    }
  },
  methods: {
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
    },
    async onSubmit(evt) {
      evt.preventDefault();
      const self                = this;
      self.form.organization_id = self.id;

      try {
        let response = await reportCall('/admin/reports/subsidization-report', self.form, 'blob');

        let blob  = new Blob([response.data], {type: 'application/csv'});
        let link  = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);

        link.download = 'data.csv';
        link.click();
        self.isPageBusy = false;
      } catch (error) {
        console.log('in catch1', error);
        console.log('in catch2', error.response);
        console.log('in catch3', error.response.data);
        console.log('in catch4', error.response.data.errors);
        if (error.response && error.response.data && error.response.data.errors) {
          let errors = error.response.data.errors;
          for (const [key, fieldData] of Object.entries(errors)) {
            this.validation[key] = {
              'state':   false,
              'message': fieldData[0]
            };
          }
        }
        self.isPageBusy = false;
      }
    },
    onReset() {
    },
  },
  async mounted() {
    await this._loadStructure();
    await this._loadData();
    this._preparePageData();
  },
  watch: {
    form: {
      deep: true,
      handler(val) {
        for (const [key, fieldData] of Object.entries(this.validation)) {
          if (fieldData['state'] == false) {
            this.validation[key]['state'] = true;
          }
        }
      }
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

.card-title {
  font-size: 1.75rem;
}

.action-buttons {
  text-align: right;
}

</style>
