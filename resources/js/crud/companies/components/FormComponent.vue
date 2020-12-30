<template>
  <div>

    <back-button-component :route="main_route"></back-button-component>
    <div class="card">
      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-title">Companies</h3>
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
              id="input-group-zip"
              label="Zip"
              label-for="input-zip"
          >
            <b-form-input
                id="input-zip"
                v-model="form.zip"
                required
                placeholder="Zip"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['zip']['state']">
              {{ validation['zip']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-city"
              label="City"
              label-for="input-city"
          >
            <b-form-input
                id="input-city"
                v-model="form.city"
                required
                placeholder="City"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['city']['state']">
              {{ validation['city']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-street"
              label="Street"
              label-for="input-street"
          >
            <b-form-input
                id="input-street"
                v-model="form.street"
                required
                placeholder="Street"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['street']['state']">
              {{ validation['street']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
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
    main_route: String,
    id:         String | Number,
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {},
      validation: {
        'id':         {'state': true, 'message': ''},
        'name':       {'state': true, 'message': ''},
        'zip':        {'state': true, 'message': ''},
        'city':       {'state': true, 'message': ''},
        'street':     {'state': true, 'message': ''},
        'created_at': {'state': true, 'message': ''},
        'updated_at': {'state': true, 'message': ''},
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
        window.location.href = self.main_route + '/' + response['data'].id + '/edit';
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
