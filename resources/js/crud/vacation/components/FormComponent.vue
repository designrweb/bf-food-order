<template>
  <div>

    <back-button-component :route="main_route"></back-button-component>
    <div class="card">

      <b-modal ref="orders-exists" id="bv-modal-example" hide-footer title="Warning">
        <p>But there are pre-orders in created vacation date. Would you like to cancel all orders during this period? Money will be refunded automatically.</p>
        <ul>
          <li v-for="order in validation['orders_exists']['message']">OrderID: {{order.id}}</li>
        </ul>
        <b-button @click="$refs['orders-exists'].hide()">Close</b-button>
        <b-button variant="danger" @click="proceedWithDeleteOrder($event)">Delete</b-button>
      </b-modal>

      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-title">{{ form.id ? 'Update Vacation: ' + form.name : 'Create Vacation' }}</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center" v-if="isPageBusy">
          <spinner-component></spinner-component>
        </div>

        <b-form @submit="onSubmit" @reset="onReset" v-if="!isPageBusy">
          <b-form-group
              id="input-group-name"
              label="Name"
              label-for="input-name"
          >
            <b-form-input
                id="input-name"
                v-model="form.name"
                required
                placeholder="Name"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['name']['state']">
              {{ validation['name']['message'] }}
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

          <b-form-group
              id="input-location_id"
              label="Location"
              label-for="input-location_id"
          >
            <b-form-select
                v-model="form.location_id"
                :options="locations_list"
                @change="getLocationGroupsByLocationId($event)"
                class="mb-3"
                value-field="id"
                text-field="name"
                disabled-field="notEnabled"
            ></b-form-select>
            <b-form-invalid-feedback :state="validation['location_id']['state']">
              {{ validation['location_id']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              id="input-location_group_id"
              label="Location Group"
              label-for="input-location_id"
          >
            <b-form-select
                v-model="form.location_group_id"
                :options="location_group_list"
                class="mb-3"
                multiple
                value-field="id"
                text-field="name"
                disabled-field="notEnabled"
            ></b-form-select>
            <b-form-invalid-feedback :state="validation['location_group_id']['state']">
              {{ validation['location_group_id']['message'] }}
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
import {getItem, store, getLocationGroupsByLocationId} from "../../api/crudRequests";
import SpinnerComponent                                from "../../shared/SpinnerComponent";
import BackButtonComponent                             from "../../shared/BackButtonComponent";

export default {
  components: {
    'spinner-component':     SpinnerComponent,
    'back-button-component': BackButtonComponent,
  },
  props:      {
    main_route:     String,
    locations_list: Array,
    id:             String | Number,
  },
  data() {
    return {
      isPageBusy:          false,
      itemData:            [],
      location_group_list: [],
      form:                {},
      validation:          {
        'id':                {'state': true, 'message': ''},
        'name':              {'state': true, 'message': ''},
        'start_date':        {'state': true, 'message': ''},
        'end_date':          {'state': true, 'message': ''},
        'location_id':       {'state': true, 'message': ''},
        'location_group_id': {'state': true, 'message': ''},
        'orders_exists':     {'state': true, 'message': ''},
      },
    }
  },
  methods:    {
    async proceedWithDeleteOrder(evt) {
      this.form['with_deleting_orders'] = true;
      await this.onSubmit(evt);
      self.$refs['orders-exists'].hide();
    },
    async getLocationGroupsByLocationId(event) {
      if (this.form.location_id == null) return;

      try {
        let response             = await getLocationGroupsByLocationId('/admin/location-groups/get-list-by-location/' + this.form.location_id);
        this.location_group_list = response['data'];
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          let errors = error.response.data.errors;
        }
      }
    },
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

          if (this.validation['orders_exists'].state === false) {
            self.$refs['orders-exists'].show();
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
    await this.getLocationGroupsByLocationId();
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
