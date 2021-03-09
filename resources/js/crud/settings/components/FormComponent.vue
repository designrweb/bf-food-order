<template>
  <div>

    <back-button-component :route="main_route"></back-button-component>
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
          <b-form-group
              id="input-group-setting_name"
              label="Einstellung Name"
              label-for="input-setting_name"
          >
            <b-form-input
                id="input-setting_name"
                v-model="form.setting_name"
                :disabled="Boolean(form.id)"
                required
                placeholder="Einstellung Name"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['setting_name']['state']">
              {{ validation['setting_name']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-visible_name"
              label="Sichtbarer Name"
              label-for="input-visible_name"
          >
            <b-form-input
                id="input-visible_name"
                v-model="form.visible_name"
                required
                placeholder="Sichtbarer Name"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['visible_name']['state']">
              {{ validation['visible_name']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-value"
              label="Wert"
              label-for="input-value"
          >
            <b-form-input
                id="input-value"
                v-model="form.value"
                required
                placeholder="Wert"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['value']['state']">
              {{ validation['value']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-button id="settings-submit-btn" type="submit" variant="primary">Einreichen</b-button>
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
    title: String
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {},
      validation: {
        'id':           {'state': true, 'message': ''},
        'setting_name': {'state': true, 'message': ''},
        'visible_name': {'state': true, 'message': ''},
        'value':        {'state': true, 'message': ''},
        'created_at':   {'state': true, 'message': ''},
        'updated_at':   {'state': true, 'message': ''},
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
