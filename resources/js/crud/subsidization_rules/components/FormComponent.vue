<template>
  <div>

    <back-button-component :route="main_route"></back-button-component>
    <div class="card">
      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-title">{{ form.id ? 'Update Rule: ' + form.rule_name : 'Create Rule' }}</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center" v-if="isPageBusy">
          <spinner-component></spinner-component>
        </div>

        <b-form @submit="onSubmit" @reset="onReset" v-if="!isPageBusy">
          <b-form-group
              id="input-group-rule_name"
              label="Rule Name"
              label-for="input-rule_name"
          >
            <b-form-input
                id="input-rule_name"
                v-model="form.rule_name"
                required
                placeholder="Rule Name"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['rule_name']['state']">
              {{ validation['rule_name']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-subsidization_organization_id"
              label="Subsidization Organization Id"
              label-for="input-subsidization_organization_id"
          >
            <b-form-select
                v-model="form.subsidization_organization_id"
                :options="subsidization_organizations_list"
                class="mb-3"
                value-field="id"
                text-field="name"
                disabled-field="notEnabled"
            ></b-form-select>
            <b-form-invalid-feedback :state="validation['subsidization_organization_id']['state']">
              {{ validation['subsidization_organization_id']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-start_date"
              label="Start Date"
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
              label="End Date"
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

          <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
      </div>
      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-subtitle"></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {getItem, store}    from "../../api/crudRequests";
import SpinnerComponent    from "../../shared/SpinnerComponent";
import BackButtonComponent from "../../shared/BackButtonComponent";

export default {
  components: {
    'spinner-component':     SpinnerComponent,
    'back-button-component': BackButtonComponent,
  },
  props:      {
    main_route:                       String,
    subsidization_organizations_list: Array,
    id:                               String | Number,
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {},
      validation: {
        'id':                            {'state': true, 'message': ''},
        'rule_name':                     {'state': true, 'message': ''},
        'subsidization_organization_id': {'state': true, 'message': ''},
        'start_date':                    {'state': true, 'message': ''},
        'end_date':                      {'state': true, 'message': ''},
        'created_by':                    {'state': true, 'message': ''},
        'created_at':                    {'state': true, 'message': ''},
        'updated_at':                    {'state': true, 'message': ''},
      },
    }
  },
  methods:    {
    async onSubmit(evt) {
      evt.preventDefault();
      const self      = this;
      self.isPageBusy = true;
      try {
        let response         = await store(self.main_route, self.id, self.form);
        window.location.href = self.main_route + '/' + response['data'].id;
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
    async _loadData() {
      if (this.id == null) return;

      let response  = await getItem(this.main_route, this.id);
      this.itemData = response['data'];

      for (const [key, fieldData] of Object.entries(this.itemData)) {
        this.form[key] = fieldData;
      }
    },
  },
  async mounted() {
    this.isPageBusy = true;
    await this._loadData();
    this.isPageBusy = false;
  },
  watch:      {
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
