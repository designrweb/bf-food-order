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
                <table class="table table-striped" v-if="!isPageBusy">
                    <tbody>
                    <tr v-for="(data, index) in pageData" v-bind:key="data.key">
                        <th>{{ data.label }}</th>
                        <td v-if="index === 'imageurl'">
                            <b-img v-if="data.value" rounded left :src="data.value" v-bind="{ width: 75, height: 75}" alt="Fluid image"></b-img>
                        </td>
                        <td v-else> {{ data.value }}</td>
                    </tr>
                    <tr>
                        <th>Aktuelles Guthaben</th>
                        <td><b> {{ pageData.balance.value }} €</b>
                            <p>Please transfer to the following account:
                                <br>Receiver: Lehmanns
                                <br>Credit institution: Sparkasse KölnBonn
                                <br>IBAN: <b>DE51 3705 0198 1935 3522 27</b>
                                <br>BIC: COLSDE33
                                <br>Purpose: full name of the child and customer number <strong>({{ pageData.account_id.value }})</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Mindest-Guthaben
                            <i class="fas fa-info-circle cursor-p" v-b-tooltip.hover
                               title="Bitte stellen Sie Ihr `Mindest-Guthaben` ein, um eine Nachricht zu erhalten sobald Ihr Guthaben diesen Wert unterschreitet. So werden Sie frühzeitig informiert und können Ihr Guthaben rechtzeitig aufladen."></i>
                        </th>
                        <td>{{ pageData.balance_limit.value }} €</td>
                    </tr>
                    </tbody>
                </table>

                <b-button class="btn btn-sm btn-warning m-1" v-b-modal.modal-1>
                    Mein Kind hat Anspruch auf ein vergünstigtes, subventioniertes Mittagessen.
                </b-button>

                <b-modal id="modal-1" title="BootstrapVue" ok-only>
                    <p>Sie haben die Möglichkeit für Ihr Kind ein subventioniertes Mittagessen zu bestellen, wenn Sie dazu
                        berechtigt sind.</p>

                    <p>Bitte reichen Sie uns eine Kopie des Bewilligungsbescheides vom Sozialleistungsträger (z.B. Bildungs-
                        und Teilhabepaket) ein.</p>

                    <p>Senden Sie die Kopie des Bewilligungsbescheides per Email an <a :href="'mailto:' + subsidization_support_email">
                        {{ subsidization_support_email }}</a>, per Fax an 0228
                        850 261 24 oder per Post an Lehmanns Catering GmbH, Cäsariusweg 16, 53332 Bornheim unter der Angabe
                        Ihrer myfoodorder Kundennummer {{ pageData.account_id.value }}.</p>

                    <p>Bitte beachten Sie die Laufzeit des Bewilligungsbescheides sowie den Hinweis dazu in dem Dokument
                        Allgemeine Informationen <a href="/pdf/MyFoodOrder_coolinary_AGBs.pdf" target="_blank">AGB</a></p>

                    <p>Bei Fragen, können Sie sich gerne an uns wenden.</p>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
import {getSubsidizationRulesBySubsidizationOrganizationId, storeFormData} from "../../../api/crudRequests";

import {EditButton, DeleteButton}  from "../../../shared/grid-buttons";
import {getViewStructure, getItem} from "../../../api/crudRequests";
import SpinnerComponent            from "../../../shared/SpinnerComponent";
import BackButtonComponent         from "../../../shared/BackButtonComponent";
import QrcodeComponent             from "../../../shared/QrcodeComponent";
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
        subsidization_support_email:     String
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
            form:                    {
                subsidization: {
                    subsidization_document: null
                }
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
        async _loadStructure() {
            this.isPageBusy   = true;
            let data          = await getViewStructure(this.main_route);
            this.fields       = data['data']['fields'];
            this.allowActions = data['data']['allowActions'];
            this.isPageBusy   = false;
        },
        async _loadData() {
            this.isPageBusy = true;
            let response    = await getItem(this.main_route, this.id);
            this.itemData   = response['data'];
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
            const self      = this;
            self.isPageBusy = true;
            try {
                const formData = new FormData();
                let headers    = {};

                _.each(this.form, (value, key) => {
                    formData.append(key, value)
                })

                if (self.selectedFile) {
                    headers = {
                        "Content-type": "multipart/form-data"
                    };
                    formData.append('subsidization[subsidization_document]', self.selectedFile, self.selectedFile.name);
                }

                if (typeof self.form.subsidization.subsidization_start !== "undefined") {
                    formData.append('subsidization[subsidization_start]', self.form.subsidization.subsidization_start);
                } else {
                    formData.append('subsidization[subsidization_start]', '');
                }

                if (typeof self.form.subsidization.subsidization_end !== "undefined") {
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
    },
    async mounted() {
        console.log(this.subsidization_support_email);
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
