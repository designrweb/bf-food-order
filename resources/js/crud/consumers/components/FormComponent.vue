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

                <b-form @submit="onSubmit" @reset="onReset" id="consumer-form" v-if="!isPageBusy">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-4">
                            <image-upload-component
                                :imageFieldName="'imageurl'"
                                :image="form.imageurl"
                                :route="main_route"
                                :entityId="form.id"
                                @changed="handleImage"
                            ></image-upload-component>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-8">
                            <b-form-group
                                id="input-group-account_id"
                                label="Kundennummer"
                                label-for="input-account_id"
                            >
                                <b-form-input
                                    id="input-account_id"
                                    v-model="form.account_id"
                                    disabled
                                    placeholder="Kundennummer"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['account_id']['state']">
                                    {{ validation['account_id']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                            <b-form-group
                                id="input-group-firstname"
                                label="Vorname"
                                label-for="input-firstname"
                            >
                                <b-form-input
                                    id="input-firstname"
                                    v-model="form.firstname"
                                    placeholder="Vorname"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['firstname']['state']">
                                    {{ validation['firstname']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-lastname"
                                label="Nachname"
                                label-for="input-lastname"
                            >
                                <b-form-input
                                    id="input-lastname"
                                    v-model="form.lastname"
                                    placeholder="Nachname"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['lastname']['state']">
                                    {{ validation['lastname']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-birthday"
                                label="Geburtstag"
                                label-for="input-birthday"
                            >
                                <date-picker
                                    :input-attr="{id: 'input-birthday'}"
                                    v-model="birthdayValue"
                                    valueType="format"
                                    format="DD.MM.YYYY"
                                    :lang="lang"
                                    input-class="form-control b-day">
                                </date-picker>
                                <b-form-invalid-feedback :state="validation['birthday']['state']">
                                    {{ validation['birthday']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-balance"
                                label="Guthaben"
                                label-for="input-balance"
                            >
                                <b-form-input
                                    id="input-balance"
                                    v-model="form.balance"
                                    placeholder="Guthaben"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['balance']['state']">
                                    {{ validation['balance']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-location_id"
                                label="Klasse"
                                label-for="input-location_id"
                            >
                                <b-form-select
                                    id="input-location_id" v-model="form.location_group_id"
                                    :options="location_group_list"
                                    class="mb-3"
                                    value-field="id"
                                    text-field="name"
                                    disabled-field="notEnabled"
                                ></b-form-select>
                                <b-form-invalid-feedback
                                    :state="validation['location_group_id']['state']">
                                    {{ validation['location_group_id']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title">{{ subsidizationTitle }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <b-form-group
                                id="input-group-balance_limit"
                                label="Guthaben Grenze"
                                label-for="input-balance_limit"
                            >
                                <b-form-input
                                    id="input-balance_limit"
                                    v-model="form.balance_limit"
                                    placeholder="Guthaben Grenze"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback
                                    :state="validation['balance_limit']['state']">
                                    {{ validation['balance_limit']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-location_id"
                                label="Name der Organisation"
                                label-for="input-subsidization-organization-id"
                            >
                                <b-form-select
                                    id="input-subsidization-organization-id"
                                    v-model="form.subsidization.subsidization_organization_id"
                                    :options="subsidization_organization_list"
                                    @change="getSubsidizationRulesBySubsidizationOrganizationId($event)"
                                    class="mb-3"
                                    value-field="id"
                                    text-field="name"
                                    disabled-field="notEnabled"
                                ></b-form-select>
                                <b-form-invalid-feedback
                                    :state="validation['subsidization.subsidization_organization_id']['state']">
                                    {{
                                    validation['subsidization.subsidization_organization_id']['message']
                                    }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-subsidization_rule_id"
                                label="Subventionierungsregel"
                                label-for="input-subsidization_rule_id"
                            >
                                <b-form-select
                                    id="input-subsidization_rule_id"
                                    v-model="form.subsidization.subsidization_rule_id"
                                    :options="subsidization_rule_list"
                                    class="mb-3"
                                    value-field="id"
                                    text-field="name"
                                    disabled-field="notEnabled"
                                ></b-form-select>
                                <b-form-invalid-feedback
                                    :state="validation['subsidization.subsidization_rule_id']['state']">
                                    {{
                                    validation['subsidization.subsidization_rule_id']['message']
                                    }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-subsidization_start_date"
                                label="Beginn Subventionsdatum"
                                label-for="input-subsidization_start_date"
                            >
                                <date-picker
                                    :input-attr="{id: 'input-subsidization_start_date'}"
                                    v-model="subsidizationStart"
                                    valueType="format"
                                    format="DD.MM.YYYY"
                                    :lang="lang"
                                    input-class="form-control b-day">
                                </date-picker>

                                <b-form-invalid-feedback
                                    :state="validation['subsidization.subsidization_start']['state']">
                                    {{ validation['subsidization.subsidization_start']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-subsidization_end_date"
                                label="Ende Subventionsdatum"
                                label-for="input-subsidization_end_date"
                            >

                                <date-picker
                                    :input-attr="{id: 'input-subsidization_end_date'}"
                                    v-model="subsidizationEnd"
                                    valueType="format"
                                    format="DD.MM.YYYY"
                                    :lang="lang"
                                    input-class="form-control b-day">
                                </date-picker>
                                <b-form-invalid-feedback
                                    :state="validation['subsidization.subsidization_end']['state']">
                                    {{ validation['subsidization.subsidization_end']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-subsidization_document"
                                label="Subventionsnachweis"
                                label-for="input-subsidization_document"
                            >
                                <b-form-file
                                    id="input-subsidization_document" accept=".pdf"
                                    v-model="form.subsidization.subsidization_document"
                                    :placeholder="(form.subsidization.subsidization_document ? form.subsidization.subsidization_document : 'Wählen Sie eine Datei oder legen Sie sie hier ab ...')"
                                    @change="change"
                                    drop-placeholder="Datei hier ablegen ..."
                                ></b-form-file>
                                <b-form-invalid-feedback
                                    :state="validation['subsidization.subsidization_document']['state']">
                                    {{
                                    validation['subsidization.subsidization_document']['message']
                                    }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </div>
                    </div>

                    <b-button id="consumers-submit-btn" type="submit" variant="primary">Einreichen
                    </b-button>
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
import {
    getItem,
    getSubsidizationRulesBySubsidizationOrganizationId,
    storeFormData
}                           from "../../api/crudRequests";
import SpinnerComponent     from "../../shared/SpinnerComponent";
import BackButtonComponent  from "../../shared/BackButtonComponent";
import ImageUploadComponent from "../../shared/ImageUploadComponent";
import _                    from 'lodash'
import DatePicker           from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/de';

export default {
    components: {
        'spinner-component':      SpinnerComponent,
        'back-button-component':  BackButtonComponent,
        'image-upload-component': ImageUploadComponent,
        DatePicker
    },
    props:      {
        main_route:                      String,
        location_group_list:             Array,
        subsidization_organization_list: Array,
        id:                              String | Number,
        title:                           String,
        subsidizationTitle:              String,
    },
    data() {
        return {
            birthdayValue:           '',
            subsidizationStart:      null,
            subsidizationEnd:        null,
            lang:                    {
                formatLocale:    {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            isPageBusy:              false,
            selectedFile:            null,
            itemData:                [],
            subsidization_rule_list: [],
            form:                    {
                balance_limit: 25,
                subsidization: {
                    subsidization_document: null
                }
            },
            validation:              {
                'id':                                          {'state': true, 'message': ''},
                'account_id':                                  {'state': true, 'message': ''},
                'firstname':                                   {'state': true, 'message': ''},
                'lastname':                                    {'state': true, 'message': ''},
                'birthday':                                    {'state': true, 'message': ''},
                'imageurl':                                    {'state': true, 'message': ''},
                'balance':                                     {'state': true, 'message': ''},
                'balance_limit':                               {'state': true, 'message': ''},
                'location_group_id':                           {'state': true, 'message': ''},
                'created_at':                                  {'state': true, 'message': ''},
                'updated_at':                                  {'state': true, 'message': ''},
                'deleted_at':                                  {'state': true, 'message': ''},
                'subsidization.subsidization_rule_id':         {'state': true, 'message': ''},
                'subsidization.subsidization_organization_id': {'state': true, 'message': ''},
                'subsidization.subsidization_start':           {'state': true, 'message': ''},
                'subsidization.subsidization_end':             {'state': true, 'message': ''},
                'subsidization.subsidization_document':        {'state': true, 'message': ''},
            },
        }
    },
    methods: {
        change(e) {
            this.selectedFile = e.target.files[0];
        },
        createImage(file) {
            let reader    = new FileReader();
            let vm        = this;
            reader.onload = (e) => {
                vm.form.subsidization.subsidization_document = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        async getSubsidizationRulesBySubsidizationOrganizationId() {
            if (this.form.subsidization.subsidization_organization_id === null) return;

            try {
                let response                 = await getSubsidizationRulesBySubsidizationOrganizationId('/admin/subsidization-rules/get-list-by-organization/' + this.form.subsidization.subsidization_organization_id);
                this.subsidization_rule_list = response['data'];
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    let errors = error.response.data.errors;
                }
            }
        },
        handleImage(dataImage) {
            this.form.imageurl = dataImage;
        },
        async onSubmit(evt) {
            evt.preventDefault();
            const self      = this;
            self.isPageBusy = true;
            try {
                const formData = new FormData();
                let headers    = {};

                this.form.birthday                          = this.birthdayValue;
                self.form.subsidization.subsidization_start = this.subsidizationStart;
                self.form.subsidization.subsidization_end   = this.subsidizationEnd;

                _.each(this.form, (value, key) => {
                    if (value) {
                        formData.append(key, value)
                    }
                })

                if (self.selectedFile) {
                    headers = {
                        "Content-type": "multipart/form-data"
                    };
                    formData.append('subsidization[subsidization_document]', self.selectedFile, self.selectedFile.name);
                }

                if (self.form.subsidization.subsidization_start !== null) {
                    formData.append('subsidization[subsidization_start]', self.form.subsidization.subsidization_start);
                } else {
                    formData.append('subsidization[subsidization_start]', '');
                }

                if (self.form.subsidization.subsidization_end !== null) {
                    formData.append('subsidization[subsidization_end]', self.form.subsidization.subsidization_end);
                } else {
                    formData.append('subsidization[subsidization_end]', '');
                }

                if (typeof self.form.subsidization.subsidization_rule_id !== "undefined") {
                    formData.append('subsidization[subsidization_rule_id]', self.form.subsidization.subsidization_rule_id);
                } else {
                    formData.append('subsidization[subsidization_rule_id]', '');
                }

                if (self.id) {
                    formData.append('_method', 'PUT');
                }

                let response         = await storeFormData(self.main_route, self.id, formData, headers);
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

            this.birthdayValue      = this.form.birthday;
            this.subsidizationStart = this.form.subsidization.subsidization_start;
            this.subsidizationEnd   = this.form.subsidization.subsidization_end;
        },
    },
    async mounted() {
        this.isPageBusy = true;
        await this._loadData();
        await this.getSubsidizationRulesBySubsidizationOrganizationId();
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

.mx-datepicker {
    width: 100% !important;
}

</style>
