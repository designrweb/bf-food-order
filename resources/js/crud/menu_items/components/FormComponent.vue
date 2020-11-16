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
        {{validation['id']['message']}}
    </b-form-invalid-feedback>
</b-form-group>
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
    id="input-group-availability_date"
    label="Availability Date"
    label-for="input-availability_date"
>
    <b-form-input
        id="input-availability_date"
        v-model="form.availability_date"
        required
        placeholder="Availability Date"
    ></b-form-input>
    <b-form-invalid-feedback :state="validation['availability_date']['state']">
        {{validation['availability_date']['message']}}
    </b-form-invalid-feedback>
</b-form-group>
<b-form-group
    id="input-group-location_id"
    label="Location Id"
    label-for="input-location_id"
>
    <b-form-input
        id="input-location_id"
        v-model="form.location_id"
        required
        placeholder="Location Id"
    ></b-form-input>
    <b-form-invalid-feedback :state="validation['location_id']['state']">
        {{validation['location_id']['message']}}
    </b-form-invalid-feedback>
</b-form-group>
<b-form-group
    id="input-group-description"
    label="Description"
    label-for="input-description"
>
    <b-form-input
        id="input-description"
        v-model="form.description"
        required
        placeholder="Description"
    ></b-form-input>
    <b-form-invalid-feedback :state="validation['description']['state']">
        {{validation['description']['message']}}
    </b-form-invalid-feedback>
</b-form-group>
<b-form-group
    id="input-group-menu_category_id"
    label="Menu Category Id"
    label-for="input-menu_category_id"
>
    <b-form-input
        id="input-menu_category_id"
        v-model="form.menu_category_id"
        required
        placeholder="Menu Category Id"
    ></b-form-input>
    <b-form-invalid-feedback :state="validation['menu_category_id']['state']">
        {{validation['menu_category_id']['message']}}
    </b-form-invalid-feedback>
</b-form-group>
<b-form-group
    id="input-group-imageurl"
    label="Imageurl"
    label-for="input-imageurl"
>
    <b-form-input
        id="input-imageurl"
        v-model="form.imageurl"
        required
        placeholder="Imageurl"
    ></b-form-input>
    <b-form-invalid-feedback :state="validation['imageurl']['state']">
        {{validation['imageurl']['message']}}
    </b-form-invalid-feedback>
</b-form-group>
<b-form-group
    id="input-group-created_at"
    label="Created At"
    label-for="input-created_at"
>
    <b-form-input
        id="input-created_at"
        v-model="form.created_at"
        required
        placeholder="Created At"
    ></b-form-input>
    <b-form-invalid-feedback :state="validation['created_at']['state']">
        {{validation['created_at']['message']}}
    </b-form-invalid-feedback>
</b-form-group>
<b-form-group
    id="input-group-updated_at"
    label="Updated At"
    label-for="input-updated_at"
>
    <b-form-input
        id="input-updated_at"
        v-model="form.updated_at"
        required
        placeholder="Updated At"
    ></b-form-input>
    <b-form-invalid-feedback :state="validation['updated_at']['state']">
        {{validation['updated_at']['message']}}
    </b-form-invalid-feedback>
</b-form-group>

                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
            </div>
        </div>
    </div>
</template>

<script>
    import {getItem, store} from "../../api/crudRequests";
    import SpinnerComponent               from "../../shared/SpinnerComponent";
    import BackButtonComponent            from "../../shared/BackButtonComponent";

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
                isPageBusy:   false,
                itemData:     [],
                form:         {},
                validation:   {
            'id':{'state': true,'message': ''},'name':{'state': true,'message': ''},'availability_date':{'state': true,'message': ''},'location_id':{'state': true,'message': ''},'description':{'state': true,'message': ''},'menu_category_id':{'state': true,'message': ''},'imageurl':{'state': true,'message': ''},'created_at':{'state': true,'message': ''},'updated_at':{'state': true,'message': ''},
                },
            }
        },
        methods:    {
            async onSubmit(evt) {
                evt.preventDefault();
                const self = this;
                self.isPageBusy = true;
                try {
                    let response = await store(self.main_route, self.id, self.form);
                    window.location.href = self.main_route + '/' + response['data'].id;
                } catch (error) {
                    if (error.response && error.response.data && error.response.data.errors) {
                        let errors = error.response.data.errors;
                        for(const [key, fieldData] of Object.entries(errors)) {
                            this.validation[key] = {
                                'state':false,
                                'message':fieldData[0]
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
                    for(const [key, fieldData] of Object.entries(this.validation)) {
                        if(fieldData['state'] == false){
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
