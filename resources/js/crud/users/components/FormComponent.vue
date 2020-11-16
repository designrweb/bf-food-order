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
                            {{validation['name']['message']}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-email"
                        label="Email"
                        label-for="input-email"
                    >
                        <b-form-input
                            id="input-email"
                            v-model="form.email"
                            required
                            placeholder="Email"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['email']['state']">
                            {{validation['email']['message']}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-password"
                        label="Password"
                        label-for="input-password"
                    >
                        <b-form-input
                            id="input-password"
                            v-model="form.password"
                            placeholder="Password"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['password']['state']">
                            {{validation['password']['message']}}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group
                        id="input-group-first_name"
                        label="First Name"
                        label-for="input-first_name"
                    >
                        <b-form-input
                            id="input-first_name"
                            v-model="form.user_info.first_name"
                            required
                            placeholder="First Name"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['user_info.first_name']['state']">
                            {{validation['user_info.first_name']['message']}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-last_name"
                        label="Last Name"
                        label-for="input-last_name"
                    >
                        <b-form-input
                            id="input-last_name"
                            v-model="form.user_info.last_name"
                            required
                            placeholder="Last Name"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['user_info.last_name']['state']">
                            {{validation['user_info.last_name']['message']}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-salutation"
                        label="Salutation"
                        label-for="input-salutation"
                    >
                        <b-form-input
                            id="input-salutation"
                            v-model="form.user_info.salutation"
                            required
                            placeholder="Salutation"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['user_info.salutation']['state']">
                            {{validation['user_info.salutation']['message']}}
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
                            required
                            placeholder="Zip"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['user_info.zip']['state']">
                            {{validation['user_info.zip']['message']}}
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
                            required
                            placeholder="City"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['user_info.city']['state']">
                            {{validation['user_info.city']['message']}}
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
                            required
                            placeholder="Street"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['user_info.street']['state']">
                            {{validation['user_info.street']['message']}}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-button type="submit" variant="primary">Submit</b-button>
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
                form:       {
                    user_info: {}
                },
                validation: {
                    'name':                 {'state': true, 'message': ''},
                    'email':                {'state': true, 'message': ''},
                    'password':             {'state': true, 'message': ''},
                    'user_info.first_name': {'state': true, 'message': ''},
                    'user_info.last_name':  {'state': true, 'message': ''},
                    'user_info.salutation': {'state': true, 'message': ''},
                    'user_info.zip':        {'state': true, 'message': ''},
                    'user_info.city':       {'state': true, 'message': ''},
                    'user_info.street':     {'state': true, 'message': ''},
                },
            }
        },
        methods:    {
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
        watch:      {
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
