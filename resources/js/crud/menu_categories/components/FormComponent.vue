<template>
  <div>

    <back-button-component :route="main_route"></back-button-component>
    <div class="card">
      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-title">{{ form.id ? 'Update Menu Category: ' + form.name : 'Create Menu Category' }}</h3>
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
              id="input-group-category_order"
              label="Category Order"
              label-for="input-category_order"
          >
            <b-form-input
                id="input-category_order"
                v-model="form.category_order"
                required
                placeholder="Category Order"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['category_order']['state']">
              {{ validation['category_order']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              id="input-group-price"
              label="Price"
              label-for="input-price"
          >
            <b-form-input
                id="input-price"
                v-model="form.price"
                type="number"
                step="0.01"
                placeholder="Price"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['price']['state']">
              {{ validation['price']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              id="input-group-presaleprice"
              label="Presaleprice"
              label-for="input-presaleprice"
          >
            <b-form-input
                id="input-presaleprice"
                v-model="form.presaleprice"
                type="number"
                step="0.01"
                placeholder="Presaleprice"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['presaleprice']['state']">
              {{ validation['presaleprice']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              id="input-group-location_id"
              label="Location"
              label-for="input-location_id"
          >
            <b-form-select
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
    main_route:     String,
    locations_list: Array,
    id:             String | Number,
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {},
      validation: {
        'id':             {'state': true, 'message': ''},
        'name':           {'state': true, 'message': ''},
        'category_order': {'state': true, 'message': ''},
        'price':          {'state': true, 'message': ''},
        'presaleprice':   {'state': true, 'message': ''},
        'location_id':    {'state': true, 'message': ''},
        'created_at':     {'state': true, 'message': ''},
        'updated_at':     {'state': true, 'message': ''},
      },
    }
  },
  methods: {
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

.card-title {
  font-size: 1.75rem;
}

</style>
