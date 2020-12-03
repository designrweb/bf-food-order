<template>
  <div>

    <back-button-component :route="main_route"></back-button-component>
    <div class="card">
      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-title"></h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center" v-if="isPageBusy">
          <spinner-component></spinner-component>
        </div>

        <b-form @submit="onSubmit" @reset="onReset" id="consumer-form" v-if="!isPageBusy">
          <b-form-group
              id="input-group-account_id"
              label="Account Id"
              label-for="input-account_id"
          >
            <b-form-input
                id="input-account_id"
                v-model="form.account_id"
                required
                placeholder="Account Id"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['account_id']['state']">
              {{ validation['account_id']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-firstname"
              label="Firstname"
              label-for="input-firstname"
          >
            <b-form-input
                id="input-firstname"
                v-model="form.firstname"
                required
                placeholder="Firstname"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['firstname']['state']">
              {{ validation['firstname']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-lastname"
              label="Lastname"
              label-for="input-lastname"
          >
            <b-form-input
                id="input-lastname"
                v-model="form.lastname"
                required
                placeholder="Lastname"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['lastname']['state']">
              {{ validation['lastname']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-birthday"
              label="Birthday"
              label-for="input-birthday"
          >
            <b-form-input
                id="input-birthday"
                v-model="form.birthday"
                required
                placeholder="Birthday"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['birthday']['state']">
              {{ validation['birthday']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <image-upload-component
              :imageFieldName="'imageurl'"
              :image="form.imageurl"
              :route="main_route"
              :entityId="form.id"
              @changed="handleImage"
          ></image-upload-component>
          <b-form-group
              id="input-group-balance"
              label="Balance"
              label-for="input-balance"
          >
            <b-form-input
                id="input-balance"
                v-model="form.balance"
                required
                placeholder="Balance"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['balance']['state']">
              {{ validation['balance']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-balance_limit"
              label="Balance Limit"
              label-for="input-balance_limit"
          >
            <b-form-input
                id="input-balance_limit"
                v-model="form.balance_limit"
                required
                placeholder="Balance Limit"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['balance_limit']['state']">
              {{ validation['balance_limit']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-location_group_id"
              label="Location Group Id"
              label-for="input-location_group_id"
          >
            <b-form-input
                id="input-location_group_id"
                v-model="form.location_group_id"
                required
                placeholder="Location Group Id"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['location_group_id']['state']">
              {{ validation['location_group_id']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>
          <b-form-group
              id="input-group-user_id"
              label="User Id"
              label-for="input-user_id"
          >
            <b-form-input
                id="input-user_id"
                v-model="form.user_id"
                required
                placeholder="User Id"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['user_id']['state']">
              {{ validation['user_id']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
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
    main_route: String,
    id:         String | Number,
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {},
      validation: {
        'id':                {'state': true, 'message': ''},
        'account_id':        {'state': true, 'message': ''},
        'firstname':         {'state': true, 'message': ''},
        'lastname':          {'state': true, 'message': ''},
        'birthday':          {'state': true, 'message': ''},
        'imageurl':          {'state': true, 'message': ''},
        'balance':           {'state': true, 'message': ''},
        'balance_limit':     {'state': true, 'message': ''},
        'location_group_id': {'state': true, 'message': ''},
        'user_id':           {'state': true, 'message': ''},
        'created_at':        {'state': true, 'message': ''},
        'updated_at':        {'state': true, 'message': ''},
        'deleted_at':        {'state': true, 'message': ''},
      },
    }
  },
  methods:    {
    handleImage(dataImage) {
      this.form.imageurl = dataImage;
    },
    async onSubmit(evt) {
      evt.preventDefault();
      const self      = this;
      self.isPageBusy = true;
      try {
        let response = await store(self.main_route, self.id, self.form);
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
