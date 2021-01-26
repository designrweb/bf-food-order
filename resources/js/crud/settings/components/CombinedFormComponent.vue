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
      <div class="card-body">
        <div class="text-center" v-if="isPageBusy">
          <spinner-component></spinner-component>
        </div>

        <b-form @submit="onSubmit" @reset="onReset" v-if="!isPageBusy">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-4 mt-4">
              <image-upload-component
                  :imageFieldName="'logo'"
                  :image="form.logo"
                  :height="948"
                  :width="4410"
                  :route="main_route"
                  :entityId="''"
                  @changed="handleImage"
              ></image-upload-component>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-8">
              <b-form-group
                  id="input-group-email-value"
                  label="E-Mail zur Unterstützung der Subventionierung"
                  label-for="input-email-value"
              >
                <b-form-input
                    id="input-email-value"
                    v-model="form.email"
                    required
                    placeholder="Email"
                ></b-form-input>
                <b-form-invalid-feedback :state="validation['email']['state']">
                  {{ validation['email']['message'] }}
                </b-form-invalid-feedback>
              </b-form-group>

              <div class="row">
                <div class="col-lg-6">
                  <b-form-group
                      id="input-sidebar_theme_color-value"
                      label="Farbe der Seitenleiste des Unternehmens "
                      label-for="input-color-value"
                  >
                    <div class="row">
                      <div class="col-lg-3">
                        <b-form-input
                            id="input-sidebar_theme_color-value"
                            type="color"
                            v-model="form.sidebar_theme_color"
                            required
                            placeholder="Wert"
                        ></b-form-input>
                      </div>
                      <div class="col-lg-1">
                        <b-icon-trash @click="clearColor('sidebar_theme_color')"></b-icon-trash>
                      </div>
                    </div>

                    <b-form-invalid-feedback :state="validation['sidebar_theme_color']['state']">
                      {{ validation['sidebar_theme_color']['message'] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </div>

                <div class="col-lg-6">
                  <b-form-group
                      id="input-theme_color-group"
                      label="Firmenfarbe"
                      label-for="input-color-value"
                  >
                    <div class="row">
                      <div class="col-lg-3">
                        <b-form-input
                            id="input-theme_color-value"
                            type="color"
                            v-model="form.theme_color"
                            required
                            placeholder="Wert"
                        ></b-form-input>
                      </div>
                      <div class="col-lg-1">
                        <b-icon-trash @click="clearColor('theme_color')"></b-icon-trash>
                      </div>
                    </div>

                    <b-form-invalid-feedback :state="validation['theme_color']['state']">
                      {{ validation['theme_color']['message'] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </div>
              </div>

            </div>
          </div>
          <div class="mt-4">
            <b-button type="submit" class="float-right" variant="primary">Einreichen</b-button>
          </div>
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
import {getItems, store}    from "../../api/crudRequests";
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
    main_route: String,
    title: String
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {
        email:               null,
        sidebar_theme_color: null,
        theme_color:         null,
        logo:                null,
      },
      validation: {
        'email':               {'state': true, 'message': ''},
        'sidebar_theme_color': {'state': true, 'message': ''},
        'theme_color':         {'state': true, 'message': ''},
        'logo':                {'state': true, 'message': ''},
      },
    }
  },
  methods:    {
    clearColor(fieldName) {
      this.form[fieldName] = null;
    },
    handleImage(dataImage) {
      if (dataImage) {
        this.form.logo = dataImage;
      } else {
        this.form.logo = null;
      }
    },
    async onSubmit(evt) {
      evt.preventDefault();
      const self      = this;
      self.isPageBusy = true;
      try {
        await store(self.main_route + '/combined', self.id, self.form);
        location.reload();
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
      let response  = await getItems(this.main_route + '/combined', 1, 10, {}, {});
      this.itemData = response['data']['data'];

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


svg.icon-remove {
  width: 30px !important;
  height: 30px !important;
  top: -13.7px !important;
  right: -22.25px !important;
}

</style>
