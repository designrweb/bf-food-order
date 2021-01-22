<template>
  <div>
    <back-button-component :route="main_route"></back-button-component>
    <div class="card">
      <div class="card-header" v-if="!isPageBusy">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3 class="card-subtitle">{{ form.id ? 'Update Payment: ' + form.id : 'Add Payment' }}</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center" v-if="isPageBusy">
          <spinner-component></spinner-component>
        </div>
        <b-form @submit="onSubmit" @reset="onReset" v-if="!isPageBusy">
          <b-form-group
              id="input-group-consumer_id"
              label="Consumer Id"
              label-for="input-consumer_id"
          >
            <b-form-select
                id="input-consumer_id"
                v-model="form.consumer_id"
                required
                placeholder="Consumer Id"
                :options="consumers_list"
                class="mb-3"
                value-field="id"
                text-field="name"
                disabled-field="notEnabled"
            ></b-form-select>
            <b-form-invalid-feedback :state="validation['consumer_id']['state']">
              {{ validation['consumer_id']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              id="input-group-amount"
              label="Amount"
              label-for="input-amount"
          >
            <b-form-input
                id="input-amount"
                v-model="form.amount_locale"
                :disabled="form.id"
                required
                @keypress="isFloat($event)"
                placeholder="Amount"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['amount_locale']['state']">
              {{ validation['amount_locale']['message'] }}
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
              id="input-group-comment"
              label="Comment"
              label-for="input-comment"
          >
            <b-form-input
                id="input-comment"
                v-model="form.comment"
                :disabled="form.id"
                required
                placeholder="Comment"
            ></b-form-input>
            <b-form-invalid-feedback :state="validation['comment']['state']">
              {{ validation['comment']['message'] }}
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
    main_route:     String,
    consumers_list: Array,
    id:             String | Number,
  },
  data() {
    return {
      isPageBusy: false,
      itemData:   [],
      form:       {},
      validation: {
        'id':            {'state': true, 'message': ''},
        'amount_locale': {'state': true, 'message': ''},
        'type':          {'state': true, 'message': ''},
        'comment':       {'state': true, 'message': ''},
        'order_id':      {'state': true, 'message': ''},
        'consumer_id':   {'state': true, 'message': ''},
        'created_at':    {'state': true, 'message': ''},
        'updated_at':    {'state': true, 'message': ''},
        'transacted_at': {'state': true, 'message': ''},
      },
    }
  },
  methods: {
    isFloat: function (evt) {
      evt          = (evt) ? evt : window.event;
      let charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 44) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    async onSubmit(evt) {
      evt.preventDefault();
      const self      = this;
      self.isPageBusy = true;
      try {
        await store(self.main_route, self.id, self.form);
        window.location.href = self.main_route + '/bank-transactions';
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
