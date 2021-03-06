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
                            autocomplete="off"
                        ></b-form-input>
                        <b-form-invalid-feedback :state="validation['name']['state']">
                            {{ validation['name']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-description"
                        label="Description"
                        label-for="input-description"
                    >
                        <b-form-textarea
                            id="input-description"
                            v-model="form.description"
                            required
                            placeholder="Description"
                            autocomplete="off"
                            rows="3"
                            max-rows="6"
                        ></b-form-textarea>
                        <b-form-invalid-feedback :state="validation['description']['state']">
                            {{ validation['description']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-catering_category_id"
                        label="Catering Category"
                        label-for="input-catering_category_id"
                    >

                        <b-form-select
                            id="input-catering_category_id"
                            v-model="form.catering_category_id"
                            :options="catering_categories_list"
                            class="mb-3"
                            value-field="id"
                            text-field="name"
                            disabled-field="notEnabled"
                        ></b-form-select>

                        <b-form-invalid-feedback
                            :state="validation['catering_category_id']['state']">
                            {{ validation['catering_category_id']['message'] }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group
                        id="input-group-status"
                        label="Status"
                        label-for="input-status"
                    >
                        <b-form-select
                            id="input-status"
                            v-model="form.status"
                            :options="statuses_list"
                            class="mb-3"
                            value-field="id"
                            text-field="name"
                            disabled-field="notEnabled"
                        ></b-form-select>
                        <b-form-invalid-feedback
                            :state="validation['status']['state']">
                            {{ validation['status']['message'] }}
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
        main_route:               String,
        title:                    String,
        catering_categories_list: Array,
        statuses_list:            Array,
        id:                       String | Number,
    },
    data() {
        return {
            isPageBusy: false,
            itemData:   [],
            form:       {},
            validation: {
                'name':                 {'state': true, 'message': ''},
                'description':          {'state': true, 'message': ''},
                'catering_category_id': {'state': true, 'message': ''},
                'imageurl':             {'state': true, 'message': ''},
                'status':               {'state': true, 'message': ''},
            },
        }
    },
    methods: {
        async onSubmit(evt) {
            evt.preventDefault();
            const self      = this;
            self.isPageBusy = true;
            try {
                let response         = await store(self.main_route, self.id, self.form, true);
                window.location.href = self.main_route;
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
