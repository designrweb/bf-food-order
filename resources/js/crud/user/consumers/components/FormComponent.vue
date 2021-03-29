<template>
    <div>
        <back-button-component :route="main_route"></back-button-component>
        <div class="text-center" v-if="isPageBusy">
            <spinner-component></spinner-component>
        </div>
        <div class="card" v-if="!isPageBusy">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title">{{ title }}</h3>
                    </div>
                </div>
            </div>
            <b-form @submit="onSubmit" @reset="onReset" id="consumer-form">
                <div class="card-body">
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
                                id="input-location_id"
                                label="Location"
                                label-for="input-location_id"
                            >
                                <b-form-select
                                    id="input-location_id"
                                    v-model="form.location_id"
                                    :options="location_list"
                                    class="mb-3"
                                    value-field="id"
                                    text-field="name"
                                    @change="getLocationGroupsByLocationId"
                                    disabled-field="notEnabled"
                                ></b-form-select>
                            </b-form-group>

                            <b-form-group
                                id="input-group-location_id"
                                label="Klasse"
                                label-for="input-group-location_id"
                            >
                                <b-form-select
                                    id="input-group-location_id"
                                    v-model="form.location_group_id"
                                    :options="location_group_list"
                                    class="mb-3"
                                    value-field="id"
                                    text-field="name"
                                    :disabled="location_group_list.length === 0"
                                    disabled-field="notEnabled"
                                ></b-form-select>
                                <b-form-invalid-feedback :state="validation['location_group_id']['state']">
                                    {{ validation['location_group_id']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title">Zahlungsinformationen</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center" v-if="isPageBusy">
                                <spinner-component></spinner-component>
                            </div>
                            <b-form @submit="onSubmit" @reset="onReset" id="consumer-form-balance-limit" v-if="!isPageBusy">
                                <b-form-group
                                    label="Mindest-Guthaben"
                                    label-for="consumerform-balance_limit">
                                    <b-form-input
                                        type="number"
                                        id="consumerform-balance_limit"
                                        v-model="form.balance_limit"
                                        placeholder="Mindest-Guthaben"
                                        autocomplete="off"
                                    ></b-form-input>
                                    <b-form-invalid-feedback :state="validation['balance_limit']['state']">
                                        {{ validation['balance_limit']['message'] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                <b-button type="submit" id="consumers-submit-btn" variant="primary">Einreichen</b-button>
                            </b-form>
                        </div>
                    </div>
                </div>
            </b-form>
        </div>
    </div>
</template>

<script>
import {getItem, getLocationGroupsByLocationId, storeFormData} from "../../../api/crudRequests";
import SpinnerComponent                                        from "../../../shared/SpinnerComponent";
import BackButtonComponent                                     from "../../../shared/BackButtonComponent";
import ImageUploadComponent                                    from "../../../shared/ImageUploadComponent";
import _                                                       from 'lodash'
import DatePicker                                              from 'vue2-datepicker';
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
        main_route:         String,
        location_list:      Array,
        id:                 String | Number,
        title:              String,
        subsidizationTitle: String,
    },
    data() {
        return {
            selectedClass:       null,
            birthdayValue:       '',
            lang:                {
                formatLocale:    {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            isPageBusy:          false,
            selectedFile:        null,
            itemData:            [],
            form:                {
                balance_limit: 25,
            },
            location_group_list: [],
            validation:          {
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

                this.form.birthday = this.birthdayValue;

                _.each(this.form, (value, key) => {
                    if (value) {
                        formData.append(key, value)
                    }
                })

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

            let response = await getItem(this.main_route, this.id);

            this.itemData = response['data'];

            for (const [key, fieldData] of Object.entries(this.itemData)) {
                this.form[key] = fieldData;
            }

            this.birthdayValue = this.form.birthday;
        },
        async getLocationId() {
            if (this.id == null && this.location_list.length) {
                this.form.location_id = this.location_list[0];
                return;
            }

            let location          = await getItem('/user/location-groups', this.form.location_group_id)
            this.form.location_id = location['data'].location_id;
        },
        async getLocationGroupsByLocationId() {
            this.location_group_list = [];
            let locationGroups       = await getLocationGroupsByLocationId('/user/location-groups/get-list-by-location/' + this.form.location_id);

            this.location_group_list = locationGroups['data']
        }
    },
    async mounted() {
        this.isPageBusy = true;
        await this._loadData();
        await this.getLocationId();
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
