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
                        label="Kategorie Reihenfolge"
                        label-for="input-category_order"
                    >
                        <b-form-select
                            id="input-category_order"
                            v-model="form.category_order"
                            :options="category_order_list"
                            class="mb-3"
                        ></b-form-select>

                        <b-form-invalid-feedback :state="validation['category_order']['state']">
                            {{ validation['category_order']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group
                        id="input-group-price"
                        label="Spontanpreis"
                        label-for="input-price"
                    >
                        <b-form-input
                            ref="input-price"
                            id="input-price"
                            v-model="form.price_locale"
                            type="text"
                            @keypress="isFloat($event)"
                            :disabled="notAvailableForPos"
                            placeholder="Spontanpreis"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['price_locale']['state']">
                            {{ validation['price_locale']['message'] }}
                        </b-form-invalid-feedback>

                        <br>

                        <b-form-checkbox
                            id="input-not-available-for-pos"
                            v-model="notAvailableForPos"
                            switch
                            @change="handlerNotAvailableForPos($event)">
                            nicht verfügbar für POS
                        </b-form-checkbox>

                        <b-form-invalid-feedback :state="validation['not_available_for_pos']['state']">
                            {{ validation['not_available_for_pos']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group
                        id="input-group-presaleprice"
                        label="Vorbestell-Preis"
                        label-for="input-presaleprice"
                    >
                        <b-form-input
                            id="input-presaleprice"
                            v-model="form.presaleprice_locale"
                            type="text"
                            @keypress="isFloat($event)"
                            placeholder="Vorbestell-Preis"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['presaleprice_locale']['state']">
                            {{ validation['presaleprice_locale']['message'] }}
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

                    <b-form-group
                        id="input-group-tax_rate"
                        label="MwSt. %"
                        label-for="input-tax_rate"
                    >
                        <b-form-select
                            id="input-tax_rate"
                            v-model="form.tax_rate"
                            :options="tax_rates"
                            class="mb-3"
                            value-field="id"
                            text-field="name"
                            disabled-field="notEnabled"
                        ></b-form-select>
                        <b-form-invalid-feedback :state="validation['tax_rate']['state']">
                            {{ validation['tax_rate']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-button id="menu-categories-submit-btn" type="submit" variant="primary">Einreichen</b-button>
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
        main_route:      String,
        locations_list:  Array,
        existing_orders: Array | Object,
        id:              String | Number,
        title:           String,
        tax_rates:       Array | Object
    },
    data() {
        return {
            isPageBusy:         false,
            notAvailableForPos: false,
            itemData:           [],
            form:               {},
            validation:         {
                'id':                    {'state': true, 'message': ''},
                'name':                  {'state': true, 'message': ''},
                'category_order':        {'state': true, 'message': ''},
                'price_locale':          {'state': true, 'message': ''},
                'presaleprice_locale':   {'state': true, 'message': ''},
                'not_available_for_pos': {'state': true, 'message': ''},
                'tax_rate':              {'state': true, 'message': ''},
                'location_id':           {'state': true, 'message': ''},
                'created_at':            {'state': true, 'message': ''},
                'updated_at':            {'state': true, 'message': ''},
            },
        }
    },
    computed: {
        category_order_list: function () {
            let ordersList = [];

            for (let i = 1; i <= 30; i++) {
                ordersList.push({
                    value:    i,
                    text:     i,
                    disabled: (i in this.existing_orders) ? true : false
                });
            }

            return ordersList;
        }
    },
    methods:  {
        handlerNotAvailableForPos(value) {
            if (value === true) {
                this.$refs['input-price'].value = '0,00';
                this.form.price_locale          = '0,00';
            }
        },
        isFloat:  function (evt) {
            evt          = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 44) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        isNumber: function (evt) {
            evt          = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
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
                this.form.not_available_for_pos = this.notAvailableForPos ? '1' : '0';

                let response         = await store(self.main_route, self.id, self.form, true);
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

            this.notAvailableForPos = parseInt(this.form.not_available_for_pos) === 0 ? false : true;
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
