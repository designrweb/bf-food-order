<template>
  <div>

    <back-button-component :route="main_route"></back-button-component>
    <div class="card">
      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-subtitle">{{ form.id ? 'Update Location: ' + form.name : 'Create Location' }}</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center" v-if="isPageBusy">
          <spinner-component></spinner-component>
        </div>

        <b-form @submit="onSubmit" @reset="onReset" v-if="!isPageBusy">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-4">
              <image-upload-component
                  :imageFieldName="'image_name'"
                  :image="form.image_name"
                  :route="main_route"
                  :entityId="form.id"
                  @changed="handleImage"
              ></image-upload-component>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-8">
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
                  id="input-group-street"
                  label="Street"
                  label-for="input-street"
              >
                <b-form-input
                    id="input-street"
                    v-model="form.street"
                    placeholder="Street"
                ></b-form-input>
                <b-form-invalid-feedback :state="validation['street']['state']">
                  {{ validation['street']['message'] }}
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
                    placeholder="City"
                ></b-form-input>
                <b-form-invalid-feedback :state="validation['city']['state']">
                  {{ validation['city']['message'] }}
                </b-form-invalid-feedback>
              </b-form-group>

              <b-form-group
                  id="input-group-email"
                  label="Email"
                  label-for="input-email"
              >
                <b-form-input
                    id="input-email"
                    v-model="form.email"
                    placeholder="Email"
                ></b-form-input>
                <b-form-invalid-feedback :state="validation['email']['state']">
                  {{ validation['email']['message'] }}
                </b-form-invalid-feedback>
              </b-form-group>

              <b-form-group
                  id="input-group-company_id"
                  label="Company"
                  label-for="input-company_id"
              >
                <b-form-select
                    v-model="form.company_id"
                    :options="companies_list"
                    class="mb-3"
                    value-field="id"
                    text-field="name"
                    disabled-field="notEnabled"
                ></b-form-select>
                <b-form-invalid-feedback :state="validation['company_id']['state']">
                  {{ validation['company_id']['message'] }}
                </b-form-invalid-feedback>
              </b-form-group>

            </div>
          </div>

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
import {getItem, store}     from "../../api/crudRequests";
import SpinnerComponent     from "../../shared/SpinnerComponent";
import BackButtonComponent  from "../../shared/BackButtonComponent";
import ImageUploadComponent from "../../shared/ImageUploadComponent";

export default {
  components: {
    'spinner-component':      SpinnerComponent,
    'back-button-component':  BackButtonComponent,
    'image-upload-component': ImageUploadComponent,
  },
  props:      {
    main_route:     String,
    companies_list: Array,
    id:             String | Number,
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {},
      validation: {
        'id':         {'state': true, 'message': ''},
        'name':       {'state': true, 'message': ''},
        'street':     {'state': true, 'message': ''},
        'company_id': {'state': true, 'message': ''},
        'zip':        {'state': true, 'message': ''},
        'city':       {'state': true, 'message': ''},
        'email':      {'state': true, 'message': ''},
        'image_name': {'state': true, 'message': ''},
      },
    }
  },
  methods:    {
    handleImage(dataImage) {
      this.form.image_name = dataImage;
    },
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
