<template>
  <div>
    <div class="card">

      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-title">{{ title }}</h3>
          </div>
        </div>
      </div>

      <div class="card-body overflow-auto">
        <div class="text-center" v-if="isPageBusy">
          <spinner-component></spinner-component>
        </div>

        <b-form @reset="onReset" v-if="!isPageBusy">

          <b-form-group
              id="input-group-start_date"
              label="Startdatum"
              label-for="input-start_date"
          >
            <b-form-datepicker
                id="input-start_date"
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
              id="input-group-end_date"
              label="Enddatum"
              label-for="input-end_date"
          >
            <b-form-datepicker
                id="input-end_date"
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
              id="input-group-location_id"
              label="Einrichtung"
              label-for="input-location_id"
          >
            <b-form-select
                id="input-location_id"
                v-model="form.location_id"
                :options="locations_list"
                class="mb-3"
                value-field="id"
                text-field="name"
                disabled-field="notEnabled"
            ></b-form-select>
            <b-form-invalid-feedback :state="validation['location_id']['state']">
              {{ validation['location_id']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-button
              type="button"
              variant="primary"
              @click="submit('csv')"
          >CSV
          </b-button>
          <b-button
              type="button"
              variant="primary"
              @click="submit('pdf')"
          >PDF
          </b-button>
        </b-form>
      </div>
    </div>
  </div>
</template>

<script>
import SpinnerComponent         from "../../shared/SpinnerComponent";
import {exportCall, reportCall} from "../../api/exportRequest";

export default {
  components: {
    'spinner-component': SpinnerComponent,
  },
  props:      {
    main_route:     String,
    locations_list: Array,
    title: String
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {},
      validation: {
        'id':          {'state': true, 'message': ''},
        'location_id': {'state': true, 'message': ''},
        'start_date':  {'state': true, 'message': ''},
        'end_date':    {'state': true, 'message': ''},
      },
    }
  },
  methods: {
    async submit(reportType) {
      const self           = this;
      this.form.reportType = reportType;
      self.isPageBusy      = true;
      try {
        let response = await reportCall('/admin/' + self.main_route, self.form, 'blob');

        let blob  = new Blob([response.data], {type: 'application/' + reportType});
        let link  = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);

        link.download = 'data.' + reportType;
        link.click();
      } catch (error) {
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
  watch:   {
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

.card-title {
  font-size: 1.75rem;
}

</style>
