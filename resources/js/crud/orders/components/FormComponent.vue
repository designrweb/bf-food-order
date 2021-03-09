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

                <b-form @submit="onSubmit" @reset="onReset" v-if="!isPageBusy">
                    <b-form-group
                        id="input-group-id"
                        label="Id"
                        label-for="input-id"
                    >
                        <b-form-input
                            id="input-id"
                            v-model="form.id"
                            required
                            placeholder="Id"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['id']['state']">
                            {{ validation['id']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-type"
                        label="Typ"
                        label-for="input-type"
                    >
                        <b-form-input
                            id="input-type"
                            v-model="form.type"
                            required
                            placeholder="Typ"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['type']['state']">
                            {{ validation['type']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-menuitem_id"
                        label="Menü"
                        label-for="input-menuitem_id"
                    >
                        <b-form-input
                            id="input-menuitem_id"
                            v-model="form.menuitem_id"
                            required
                            placeholder="Menü"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['menuitem_id']['state']">
                            {{ validation['menuitem_id']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-consumer_id"
                        label="Essensteilnehmer"
                        label-for="input-consumer_id"
                    >
                        <b-form-input
                            id="input-consumer_id"
                            v-model="form.consumer_id"
                            required
                            placeholder="Essensteilnehmer"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['consumer_id']['state']">
                            {{ validation['consumer_id']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-day"
                        label="Tag"
                        label-for="input-day"
                    >
                        <b-form-input
                            id="input-day"
                            v-model="form.day"
                            required
                            placeholder="Tag"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['day']['state']">
                            {{ validation['day']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-pickedup"
                        label="Abgeholt"
                        label-for="input-pickedup"
                    >
                        <b-form-input
                            id="input-pickedup"
                            v-model="form.pickedup"
                            required
                            placeholder="Abgeholt"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['pickedup']['state']">
                            {{ validation['pickedup']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-pickedup_at"
                        label="Abholt bei"
                        label-for="input-pickedup_at"
                    >
                        <b-form-input
                            id="input-pickedup_at"
                            v-model="form.pickedup_at"
                            required
                            placeholder="Abholt bei"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['pickedup_at']['state']">
                            {{ validation['pickedup_at']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-quantity"
                        label="Menge"
                        label-for="input-quantity"
                    >
                        <b-form-input
                            id="input-quantity"
                            v-model="form.quantity"
                            required
                            placeholder="Menge"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['quantity']['state']">
                            {{ validation['quantity']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-is_subsidized"
                        label="Wird subventioniert"
                        label-for="input-is_subsidized"
                    >
                        <b-form-input
                            id="input-is_subsidized"
                            v-model="form.is_subsidized"
                            required
                            placeholder="Wird subventioniert"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['is_subsidized']['state']">
                            {{ validation['is_subsidized']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-subsidization_organization_id"
                        label="Subventionsstelle"
                        label-for="input-subsidization_organization_id"
                    >
                        <b-form-input
                            id="input-subsidization_organization_id"
                            v-model="form.subsidization_organization_id"
                            required
                            placeholder="Subventionsstelle"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['subsidization_organization_id']['state']">
                            {{ validation['subsidization_organization_id']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-created_at"
                        label="Erstellt am"
                        label-for="input-created_at"
                    >
                        <b-form-input
                            id="input-created_at"
                            v-model="form.created_at"
                            required
                            placeholder="Erstellt am"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['created_at']['state']">
                            {{ validation['created_at']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-updated_at"
                        label="Aktualisiert am"
                        label-for="input-updated_at"
                    >
                        <b-form-input
                            id="input-updated_at"
                            v-model="form.updated_at"
                            required
                            placeholder="Aktualisiert am"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['updated_at']['state']">
                            {{ validation['updated_at']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-deleted_at"
                        label="Gelöscht um"
                        label-for="input-deleted_at"
                    >
                        <b-form-input
                            id="input-deleted_at"
                            v-model="form.deleted_at"
                            required
                            placeholder="Gelöscht um"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['deleted_at']['state']">
                            {{ validation['deleted_at']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-button id="orders-submit-btn" type="submit" variant="primary">Einreichen</b-button>
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
    },
    data() {
        return {
            isPageBusy: false,
            itemData:   [],
            form:       {},
            validation: {
                'id':                            {'state': true, 'message': ''},
                'type':                          {'state': true, 'message': ''},
                'menuitem_id':                   {'state': true, 'message': ''},
                'consumer_id':                   {'state': true, 'message': ''},
                'day':                           {'state': true, 'message': ''},
                'pickedup':                      {'state': true, 'message': ''},
                'pickedup_at':                   {'state': true, 'message': ''},
                'quantity':                      {'state': true, 'message': ''},
                'is_subsidized':                 {'state': true, 'message': ''},
                'subsidization_organization_id': {'state': true, 'message': ''},
                'created_at':                    {'state': true, 'message': ''},
                'updated_at':                    {'state': true, 'message': ''},
                'deleted_at':                    {'state': true, 'message': ''},
            },
        }
    },
    methods: {
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
