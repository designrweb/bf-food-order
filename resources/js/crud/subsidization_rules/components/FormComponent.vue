<template>
    <div>

        <back-button-component :route="main_route"></back-button-component>
        <div class="card">
            <div class="card-header" v-if="!isPageBusy">
                <div class="row">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title">{{ form.id ? ': ' + form.rule_name : '' }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center" v-if="isPageBusy">
                    <spinner-component></spinner-component>
                </div>

                <b-form @submit="onSubmit" @reset="onReset" v-if="!isPageBusy">
                    <b-form-group
                        id="input-group-rule_name"
                        label="Name der Regel"
                        label-for="input-rule_name"
                    >
                        <b-form-input
                            id="input-rule_name"
                            v-model="form.rule_name"
                            required
                            placeholder="Name der Regel"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['rule_name']['state']">
                            {{ validation['rule_name']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-subsidization_organization_id"
                        label="Subventionsstelle"
                        label-for="input-subsidization_organization_id"
                    >
                        <b-form-select
                            id="input-subsidization_organization_id"
                            v-model="form.subsidization_organization_id"
                            :options="subsidization_organizations_list"
                            class="mb-3"
                            value-field="id"
                            text-field="name"
                            disabled-field="notEnabled"
                        ></b-form-select>
                        <b-form-invalid-feedback :state="validation['subsidization_organization_id']['state']">
                            {{ validation['subsidization_organization_id']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-start_date"
                        label="Startdatum"
                        label-for="input-start_date"
                    >
                        <b-form-datepicker
                            id="input-start_date"
                            v-model="form.start_date"
                            reset-button
                            class="sl-tiny-text-datepicker"
                            start-weekday="1"
                            :date-format-options="{ year: 'numeric', month: '2-digit', day: '2-digit' }"
                            locale="de"
                        ></b-form-datepicker>
                        <b-form-invalid-feedback :state="validation['start_date']['state']">
                            {{ validation['start_date']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-end_date"
                        label="Enddatum"
                        label-for="input-end_date"
                    >
                        <b-form-datepicker
                            id="input-end_date"
                            v-model="form.end_date"
                            reset-button
                            class="sl-tiny-text-datepicker"
                            start-weekday="1"
                            :date-format-options="{ year: 'numeric', month: '2-digit', day: '2-digit' }"
                            locale="de"
                        ></b-form-datepicker>
                        <b-form-invalid-feedback :state="validation['end_date']['state']">
                            {{ validation['end_date']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-5">
                                <div class="card-header">
                                    <h4>Menülinien</h4>
                                </div>
                                <div class="card-body ">
                                    <table class="w-100">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Vorbestellpreis</th>
                                            <th>Prozentsatz %</th>
                                            <th>Subventionspreis</th>
                                            <th>Resultierter Preis</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(menu_category, key) in this.form.subsidization_menu_categories_list" :key="menu_category.id">
                                            <td class="text-left">{{ menu_category.name }}</td>
                                            <td>{{ menu_category.presaleprice.replace(".", ",") }} €</td>
                                            <td>
                                                <b-form-spinbutton
                                                    :ref="`percent_full_`+ menu_category.id"
                                                    v-model="menu_category.percent_full"
                                                    :name="`menu_category[${menu_category.id}]`"
                                                    min="0"
                                                    max="100"
                                                    inline
                                                    @change="handleSubsidizationPercentage($event, menu_category.id)"
                                                ></b-form-spinbutton>
                                            </td>

                                            <td>
                                                <b-input-group style="width: 40% !important;">
                                                    <template #append>
                                                        <b-input-group-text>€</b-input-group-text>
                                                    </template>
                                                    <b-form-input
                                                        v-model="menu_category.subsidization_price"
                                                        :ref="`subsidization_price_`+ menu_category.id"
                                                        type="text"
                                                        @keypress="isNumber($event)"
                                                        min="0"
                                                        step="0.1"
                                                        @change="handleSubsidizationPrice($event, menu_category.id)"
                                                    ></b-form-input>
                                                </b-input-group>
                                            </td>

                                            <td>
                                                <span :ref="`result_subsidization_price_`+ menu_category.id">{{ menu_category.resulted_price.toString().replace(".", ",") }}</span><span> €</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <b-button id="subsidization-rules-submit-btn" type="submit" variant="primary">Einreichen</b-button>
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
import moment              from "moment";

export default {
    components: {
        'spinner-component':     SpinnerComponent,
        'back-button-component': BackButtonComponent,
    },
    props:      {
        main_route:                         String,
        subsidization_organizations_list:   Array,
        subsidization_menu_categories_list: Object,
        id:                                 String | Number,
        title:                              String
    },
    data() {
        return {
            isPageBusy: false,
            itemData:   [],
            form:       {
                subsidization_menu_categories_list: {}
            },
            validation: {
                'id':                            {'state': true, 'message': ''},
                'rule_name':                     {'state': true, 'message': ''},
                'subsidization_organization_id': {'state': true, 'message': ''},
                'start_date':                    {'state': true, 'message': ''},
                'end_date':                      {'state': true, 'message': ''},
                'created_by':                    {'state': true, 'message': ''},
                'created_at':                    {'state': true, 'message': ''},
                'updated_at':                    {'state': true, 'message': ''},
            },
        }
    },
    computed: {
        endDateForPicker() {
            return moment(this.form.end_date, 'dddd, DD.MM.YYYY').format('DD.MM.YYYY')
        }
    },
    methods:  {
        isNumber: function (evt) {
            evt          = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 44) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        handleSubsidizationPercentage(val, id) {
            let subsidizationPrice       = 'subsidization_price_' + id;
            let resultSubsidizationPrice = 'result_subsidization_price_' + id;
            let presaleprice             = this.form.subsidization_menu_categories_list[id].presaleprice;
            let value                    = (presaleprice * (val / 100)).toFixed(2);

            this.$refs[subsidizationPrice][0].value           = value.replace(".", ",");
            this.$refs[resultSubsidizationPrice][0].innerText = (presaleprice - value).toFixed(2).replace(".", ",");
        },
        handleSubsidizationPrice(val, id) {
            let percentFull              = 'percent_full_' + id;
            let resultSubsidizationPrice = 'result_subsidization_price_' + id;
            let presaleprice             = this.form.subsidization_menu_categories_list[id].presaleprice;

            if (this.$refs[percentFull][0].value < 100) {
                let value                                         = parseInt((val / presaleprice) * 100);
                this.$refs[percentFull][0].value                  = value.replace(".", ",");
                this.$refs[resultSubsidizationPrice][0].innerText = (presaleprice - parseFloat(val).toFixed(2)).toFixed(2).replace(".", ",");
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
                }
                self.isPageBusy = false;
            }
        },
        onReset() {
        },
        async _loadData() {
            this.form.subsidization_menu_categories_list = this.subsidization_menu_categories_list
            if (this.id == null) return;

            let response  = await getItem(this.main_route, this.id);
            this.itemData = response['data'];

            for (const [key, fieldData] of Object.entries(this.itemData)) {
                this.form[key] = fieldData;
            }

            this.form.start_date = moment(this.form.start_date, 'dddd, DD.MM.YYYY').format('YYYY-MM-DD')
            this.form.end_date = moment(this.form.end_date, 'dddd, DD.MM.YYYY').format('YYYY-MM-DD')
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
