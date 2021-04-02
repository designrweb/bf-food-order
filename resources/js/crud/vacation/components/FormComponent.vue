<template>
    <div>
        <back-button-component :route="main_route"></back-button-component>
        <div class="card">

            <b-modal ref="orders-exists" id="bv-modal-example" hide-footer title="Warnung">
                <p>Möchten Sie alle Bestellungen in diesem Zeitraum stornieren? Das Geld wird den Bestellern automatisch gutgeschrieben</p>
                <ul>
                    <li v-for="order in validation['orders_exists']['message']">Bestellung #: {{ order.id }}</li>
                </ul>
                <b-button @click="$refs['orders-exists'].hide()">Schließen</b-button>
                <b-button variant="danger" @click="proceedWithDeleteOrder($event)">Löschen</b-button>
            </b-modal>

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
                        id="input-group-start_date"
                        label="Startdatum"
                        label-for="input-start_date"
                    >
                        <date-picker
                            :input-attr="{id: 'input-start_date'}"
                            v-model="startDate"
                            valueType="format"
                            format="DD.MM.YYYY"
                            :lang="lang"
                            :disabled-date="(date) => date <= new Date()"
                            input-class="form-control">
                        </date-picker>
                        <b-form-invalid-feedback :state="validation['start_date']['state']">
                            {{ validation['start_date']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group
                        id="input-group-end_date"
                        label="Enddatum"
                        label-for="input-end_date"
                    >
                        <date-picker
                            :input-attr="{id: 'input-end_date'}"
                            v-model="endDate"
                            valueType="format"
                            format="DD.MM.YYYY"
                            :lang="lang"
                            :disabled-date="(date) => date <= new Date()"
                            input-class="form-control">
                        </date-picker>
                        <b-form-invalid-feedback :state="validation['end_date']['state']">
                            {{ validation['end_date']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group
                        id="input-location_id"
                        label="Einrichtung"
                        label-for="input-location_id"
                    >
                        <b-form-select
                            id="input-location_id"
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
                        label="Klasse"
                        label-for="input-location_group_id"
                    >
                        <multiselect
                            v-model="location_group_ids"
                            :options="location_group_list"
                            mode="tags"
                            placeholder="Nimm welche"
                            noResultsText="Liste ist leer."
                            noOptionsText="Liste ist leer."
                        >
                            <template v-slot:tag="{ option, handleTagRemove, disabled }">
                                <div class="multiselect-tag is-user">
                                    {{ option.name }}
                                    <i
                                        v-if="!disabled"
                                        @click.prevent
                                        @mousedown.prevent.stop="handleTagRemove(option, $event)"
                                    />
                                </div>
                            </template>

                            <template v-slot:option="{ option }">
                                {{ option.name }}
                            </template>
                        </multiselect>
                        <b-form-invalid-feedback :state="validation['location_group_id']['state']">
                            {{ validation['location_group_id']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-button id="vacation-submit-btn" type="submit" variant="primary">Einreichen</b-button>
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
import DatePicker                                      from 'vue2-datepicker'
import Multiselect                                     from '@vueform/multiselect/dist/multiselect.vue2.js'
import _                                               from 'lodash'

export default {
    components: {
        'spinner-component':     SpinnerComponent,
        'back-button-component': BackButtonComponent,
        DatePicker,
        Multiselect
    },
    props:      {
        main_route:     String,
        locations_list: Array,
        id:             String | Number,
        title:          String,
    },
    data() {
        return {
            isPageBusy:          false,
            itemData:            [],
            location_group_list: [],
            location_group_ids:  [],
            form:                {},
            startDate:           null,
            endDate:             null,
            lang:                {
                formatLocale:    {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
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
    methods: {
        async proceedWithDeleteOrder(evt) {
            this.form['with_deleting_orders'] = true;
            await this.onSubmit(evt);
            self.$refs['orders-exists'].hide();
        },
        async getLocationGroupsByLocationId(event) {
            if (this.form.location_id == null) return;

            this.location_group_ids  = [];
            this.location_group_list = [];

            try {
                let response             = await getLocationGroupsByLocationId('/admin/location-groups/get-list-by-location/' + this.form.location_id);
                this.location_group_list = _.map(response['data'], location => ({value: location.id, name: location.name}))

                this.location_group_ids = _.map(this.form.location_group_id, 'id');
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

            //prepare data
            self.form.location_group_id = self.location_group_ids;
            self.form.start_date        = this.startDate;
            self.form.end_date          = this.endDate;
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

            this.startDate = this.form.start_date;
            this.endDate   = this.form.end_date;

        },
    },
    async mounted() {
        this.isPageBusy = true;
        await this._loadData();
        await this.getLocationGroupsByLocationId();
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
<style src="@vueform/multiselect/themes/default.css"></style>

<style lang="scss">
@import './node_modules/bootstrap/scss/bootstrap.scss';
@import './node_modules/bootstrap-vue/src/index.scss';

.card-title {
    font-size: 1.75rem;
}

.mx-datepicker {
    width: 100% !important;
}

</style>
