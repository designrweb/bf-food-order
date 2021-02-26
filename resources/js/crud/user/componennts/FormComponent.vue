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
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <b-form-group
                                id="input-group-firstname"
                                label="Vorname"
                                label-for="input-firstname"
                            >
                                <b-form-input
                                    id="input-first_name"
                                    v-model="form.user_info.first_name"
                                    placeholder="Vorname"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['user_info']['first_name']['state']">
                                    {{ validation['user_info']['first_name']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-lastname"
                                label="Nachname"
                                label-for="input-lastname"
                            >
                                <b-form-input
                                    id="input-lastname"
                                    v-model="form.user_info.last_name"
                                    placeholder="Nachname"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['user_info']['last_name']['state']">
                                    {{ validation['user_info']['last_name']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-birthday"
                                label="Geburtstag"
                                label-for="input-birthday"
                            >
                                <date-picker
                                    v-model="birthdayValue"
                                    :default-value="birthdayValue"
                                    valueType="format"
                                    format="DD.MM.YYYY"
                                    :lang="lang"
                                    input-class="form-control b-day">
                                </date-picker>
                                <b-form-invalid-feedback :state="validation['user_info']['birthday']['state']">
                                    {{ validation['user_info']['birthday']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-city"
                                label="City"
                                label-for="input-city"
                            >
                                <b-form-input
                                    id="input-city"
                                    v-model="form.user_info.city"
                                    placeholder="City"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['user_info']['city']['state']">
                                    {{ validation['user_info']['city']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-zip"
                                label="Zip"
                                label-for="input-zip"
                            >
                                <b-form-input
                                    id="input-zip"
                                    v-model="form.user_info.zip"
                                    placeholder="Zip"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['user_info']['zip']['state']">
                                    {{ validation['user_info']['zip']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group
                                id="input-group-street"
                                label="Street"
                                label-for="input-street"
                            >
                                <b-form-input
                                    id="input-street"
                                    v-model="form.user_info.street"
                                    placeholder="Street"
                                    autocomplete="off"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="validation['user_info']['street']['state']">
                                    {{ validation['user_info']['street']['message'] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </div>
                    </div>


                    <b-button type="submit" variant="primary">Einreichen</b-button>
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
    storeFormData,
    getLocationGroupsByLocationId
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
        main_route:    String,
        // location_list: Array,
        // subsidization_organization_list: Array,
        id:                 String | Number,
        title:              String,
        // subsidizationTitle: String,
        user:               Object,
    },
    data() {
        return {
            birthdayValue:           '',
            location_group_list:     [],
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
                user_info:     {
                    first_name: ''
                },
                subsidization: {
                    subsidization_document: null
                }
            },
            validation:              {
                'id':        {'state': true, 'message': ''},
                'user_info': {
                    'first_name': {'state': true, 'message': ''},
                    'last_name':  {'state': true, 'message': ''},
                    'salutation': {'state': true, 'message': ''},
                    'birthday':   {'state': true, 'message': ''},
                    'image_url':  {'state': true, 'message': ''},
                    'city':       {'state': true, 'message': ''},
                    'zip':        {'state': true, 'message': ''},
                    'street':     {'state': true, 'message': ''},
                },


                // 'subsidization.subsidization_rule_id':         {'state': true, 'message': ''},
                // 'subsidization.subsidization_organization_id': {'state': true, 'message': ''},
                // 'subsidization.subsidization_start':           {'state': true, 'message': ''},
                // 'subsidization.subsidization_end':             {'state': true, 'message': ''},
                // 'subsidization.subsidization_document':        {'state': true, 'message': ''},
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
            this.form.user_info.image_url = dataImage;
        },
        async onSubmit(evt) {
            evt.preventDefault();
            const self      = this;
            self.isPageBusy = true;
            try {
                const formData = new FormData();
                let headers    = {};

                this.form.user_info.birthday = this.birthdayValue;

                _.each(this.form, (value, key) => {
                    if (_.isObject(value)) {
                        _.each(value, (objectValue, objectKey) => {
                            formData.append(`${key}[${objectKey}]`, objectValue)
                        })
                    } else {
                        formData.append(key, value)
                    }
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

                let response = await storeFormData(self.main_route, self.id, formData, headers);
                // window.location.href = self.main_route + '/' + response['data'].id;

                self.isPageBusy = false;
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    let errors = error.response.data.errors;
                    for (const [key, fieldData] of Object.entries(errors)) {
                        if (key.split('.').length === 2) {
                            this.validation[key.split('.')[0]][key.split('.')[1]] = {
                                'state':   false,
                                'message': fieldData[0]
                            }
                        } else {
                            this.validation[key] = {
                                'state':   false,
                                'message': fieldData[0]
                            };
                        }
                    }
                }

                self.isPageBusy = false;
            }
        },
        onReset() {
        },
        async _loadData() {
            if (!this.user) return;

            for (const [key, fieldData] of Object.entries(this.user)) {
                this.form[key] = fieldData;
            }

            this.birthdayValue = this.form.user_info.birthday;
        },
        async getLocationGroupsByLocationId() {
            let {data} = await getLocationGroupsByLocationId(`/user/location-groups/get-list-by-location/${this.form.location_id}`)

            this.location_group_list = data;
        }
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
                    if (_.isObject(fieldData)) {
                        _.each(fieldData, (objectValue, objectKey) => {
                            if (objectValue['state'] == false) {
                                this.validation[key][objectKey]['state'] = true;
                            }
                        })
                    } else {
                        if (fieldData['state'] == false) {
                            this.validation[key]['state'] = true;
                        }
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
