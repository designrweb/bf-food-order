<template>
    <div>
        <back-button-component :route="main_route"></back-button-component>
        <div class="card">
            <div class="card-header" v-if="!isPageBusy">
                <div class="row">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="col-12 col-sm-4 action-buttons">
                        <edit-button v-if="allowActions.edit && allowActions.all" :id="id"
                                     :mainRoute="main_route"></edit-button>
                        <delete-button v-if="allowActions.delete && allowActions.all" :id="id"
                                       :mainRoute="main_route"></delete-button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="text-center" v-if="isPageBusy">
                    <spinner-component></spinner-component>
                </div>
                <table class="table table-striped">
                    <tbody>
                    <tr v-for="(data, index) in pageData" v-bind:key="data.key">
                        <th>{{ data.label }}</th>
                        <td v-if="index === 'imageurl'">
                            <b-img v-if="data.value" rounded left :src="data.value" v-bind="{ width: 75, height: 75}" alt="Fluid image"></b-img>
                        </td>
                        <td v-else> {{ data.value }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <h3 class="card-title">Payment information</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center" v-if="isPageBusy">
                            <spinner-component></spinner-component>
                        </div>
                        <b-form @submit="onSubmit" @reset="onReset" id="consumer-form" v-if="!isPageBusy">
                            <b-form-group
                                label="Organization name"
                                label-for="input-location_id"
                            >
                                <b-form-select
                                    id="input-location_id"
                                    v-model="form.subsidization.subsidization_organization_id"
                                    :options="subsidization_organization_list"
                                    @change="getSubsidizationRulesBySubsidizationOrganizationId($event)"
                                    class="mb-3"
                                    value-field="id"
                                    text-field="name"
                                    disabled-field="notEnabled"
                                ></b-form-select>
                                <b-form-invalid-feedback :state="validation['subsidization.subsidization_organization_id']['state']">
                                    {{ validation['subsidization.subsidization_organization_id']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-subsidization_rule_id"
                                label="Subsidization Rule"
                                label-for="input-subsidization_rule_id"
                            >
                                <b-form-select
                                    v-model="form.subsidization.subsidization_rule_id"
                                    :options="subsidization_rule_list"
                                    class="mb-3"
                                    value-field="id"
                                    text-field="name"
                                    disabled-field="notEnabled"
                                ></b-form-select>
                                <b-form-invalid-feedback :state="validation['subsidization.subsidization_rule_id']['state']">
                                    {{ validation['subsidization.subsidization_rule_id']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-subsidization_start_date"
                                label="Subsidization Start Date"
                                label-for="input-subsidization_start_date"
                            >
                                <date-picker
                                    :input-attr="{id: 'input-subsidization_start_date'}"
                                    v-model="subsidizationStart"
                                    @clear="clearStartDate"
                                    valueType="format"
                                    format="DD.MM.YYYY"
                                    :lang="lang"
                                    input-class="form-control">
                                </date-picker>
                                <b-form-invalid-feedback :state="validation['subsidization.subsidization_start']['state']">
                                    {{ validation['subsidization.subsidization_start']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-subsidization_end_date"
                                label="Subsidization End Date"
                                label-for="input-subsidization_end_date"
                            >
                                <date-picker
                                    :input-attr="{id: 'input-subsidization_end_date'}"
                                    v-model="subsidizationEnd"
                                    @clear="clearEndDate"
                                    valueType="format"
                                    format="DD.MM.YYYY"
                                    :lang="lang"
                                    input-class="form-control">
                                </date-picker>
                                <b-form-invalid-feedback :state="validation['subsidization.subsidization_end']['state']">
                                    {{ validation['subsidization.subsidization_end']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-subsidization_document"
                                label="Subsidization Document"
                                label-for="input-subsidization_document"
                            >
                                <b-form-file
                                    accept=".pdf"
                                    v-model="form.subsidization.subsidization_document"
                                    :placeholder="(form.subsidization.subsidization_document ? form.subsidization.subsidization_document : 'Wählen Sie eine Datei oder legen Sie sie hier ab ...')"
                                    drop-placeholder="Datei hier ablegen ..."
                                    @change="fileChange"
                                ></b-form-file>
                                <b-form-invalid-feedback :state="validation['subsidization.subsidization_document']['state']">
                                    {{ validation['subsidization.subsidization_document']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-button id="consumers-subsidization-submit-btn" type="submit" variant="primary">Submit</b-button>
                        </b-form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import {getSubsidizationRulesBySubsidizationOrganizationId, storeFormData} from "../../api/crudRequests";

import {EditButton, DeleteButton}  from "../../shared/grid-buttons";
import {getViewStructure, getItem} from "../../api/crudRequests";
import SpinnerComponent            from "../../shared/SpinnerComponent";
import BackButtonComponent         from "../../shared/BackButtonComponent";
import QrcodeComponent             from "../../shared/QrcodeComponent";
import _                           from "lodash";

export default {
    components: {
        'edit-button':           EditButton,
        'delete-button':         DeleteButton,
        'spinner-component':     SpinnerComponent,
        'back-button-component': BackButtonComponent,
        'qr-code-component':     QrcodeComponent
    },
    props:      {
        main_route:                      String,
        id:                              String | Number,
        subsidization_organization_list: Array,
    },
    data() {
        return {
            isTableBusy:             false,
            isPageBusy:              false,
            itemData:                [],
            fields:                  [],
            pageData:                {},
            allowActions:            {
                all:    true,
                create: true,
                view:   true,
                edit:   true,
                delete: true,
            },
            subsidization_rule_list: [],
            subsidizationStart:      null,
            subsidizationEnd:        null,
            form:                    {
                subsidization: {
                    subsidization_document: null
                }
            },
            lang:                    {
                formatLocale:    {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            validation:              {
                'id':                                          {'state': true, 'message': ''},
                'subsidization.subsidization_rule_id':         {'state': true, 'message': ''},
                'subsidization.subsidization_organization_id': {'state': true, 'message': ''},
                'subsidization.subsidization_start':           {'state': true, 'message': ''},
                'subsidization.subsidization_end':             {'state': true, 'message': ''},
                'subsidization.subsidization_document':        {'state': true, 'message': ''},
            },
        }
    },
    methods: {
        clearStartDate() {
            this.subsidizationStart = null;
        },
        clearEndDate() {
            this.subsidizationEnd = null;
        },
        async _loadStructure() {
            this.isPageBusy   = true;
            let data          = await getViewStructure(this.main_route);
            this.fields       = data['data']['fields'];
            this.allowActions = data['data']['allowActions'];
            this.isPageBusy   = false;
        },
        async _loadData() {
            this.isPageBusy            = true;
            let response               = await getItem(this.main_route, this.id);
            this.itemData              = response['data'];
            this.form['subsidization'] = {};
            for (const [key, fieldData] of Object.entries(this.itemData['subsidization'])) {
                this.form['subsidization'][key] = fieldData;
            }

            this.subsidizationStart = this.form.subsidization.subsidization_start;
            this.subsidizationEnd   = this.form.subsidization.subsidization_end;

            await this.getSubsidizationRulesBySubsidizationOrganizationId();
            this.isPageBusy = false;
        },

        _preparePageData() {
            const self      = this;
            this.isPageBusy = true;

            for (const [key, value] of Object.entries(this.fields)) {
                self.pageData[value.key] = {
                    'label': value.label,
                    'value': ''
                };
                let fieldValue;

                value.key.split('.').forEach(function (item, index) {
                    if (typeof fieldValue == "undefined") {
                        fieldValue = self.itemData[item];
                    } else {
                        fieldValue = fieldValue != null ? fieldValue[item] : '';
                    }
                });
                self.pageData[value.key]['value'] = fieldValue;
            }

            this.isPageBusy = false;
        },
        async onSubmit(evt) {
            evt.preventDefault();
            const self = this;
            try {
                const formData = new FormData();
                let headers    = {};

                self.form.subsidization.subsidization_start = this.subsidizationStart;
                self.form.subsidization.subsidization_end   = this.subsidizationEnd;

                _.each(this.form, (value, key) => {
                    formData.append(key, value)
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

                //add type to validate only subsidization
                formData.append('type', null);

                await storeFormData(self.main_route, self.id, formData, headers);
                window.location.reload();
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

        fileChange(e) {
            this.selectedFile = e.target.files[0];
        },
    },
    async mounted() {
        await this._loadStructure();
        await this._loadData();
        this._preparePageData();
    },
}
</script>

<style lang="scss">
@import './node_modules/bootstrap/scss/bootstrap.scss';
@import './node_modules/bootstrap-vue/src/index.scss';

.sortable {
    color: #3490dc;
    cursor: pointer;
}

.sortable:hover {
    color: #3caedc;
}

.card-title {
    font-size: 1.75rem;
}

.action-buttons {
    text-align: right;
}

</style>
