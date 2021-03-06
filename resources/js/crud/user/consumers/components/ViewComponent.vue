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
            <div class="card-body overflow-auto">
                <div class="text-center" v-if="isPageBusy">
                    <spinner-component></spinner-component>
                </div>
                <table class="table table-striped" v-if="!isPageBusy">
                    <tbody>
                    <tr v-for="(data, index) in pageData" v-bind:key="data.key">
                        <th>{{ data.label }}</th>
                        <td v-if="index === 'imageurl'">
                            <b-img v-if="data.value" rounded left :src="data.value" v-bind="{ width: 250, height: 250}" alt="Fluid image"></b-img>
                            <b-img v-else src="/image/placeholder.png"/>
                        </td>
                        <td v-else> {{ data.value ? data.value : '---' }}</td>
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

                <b-modal id="modal-1" title="Mein Kind hat Anspruch auf ein vergünstigtes, subventioniertes Mittagessen." ok-only>
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
import {EditButton, DeleteButton} from "../../../shared/grid-buttons";
import {
    getViewStructure,
    getItem,
}                                 from "../../../api/crudRequests";
import SpinnerComponent           from "../../../shared/SpinnerComponent";
import BackButtonComponent        from "../../../shared/BackButtonComponent";
import QrcodeComponent            from "../../../shared/QrcodeComponent";

export default {
    components: {
        'edit-button':           EditButton,
        'delete-button':         DeleteButton,
        'spinner-component':     SpinnerComponent,
        'back-button-component': BackButtonComponent,
        'qr-code-component':     QrcodeComponent
    },
    props:      {
        main_route:                  String,
        id:                          String | Number,
        subsidization_support_email: String
    },
    data() {
        return {
            isTableBusy:  false,
            isPageBusy:   false,
            itemData:     [],
            fields:       [],
            pageData:     {},
            allowActions: {
                all:    true,
                create: true,
                view:   true,
                edit:   true,
                delete: true,
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
        onReset() {
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
