<template>
    <div class="card">
        <div class="card-header" v-if="!isPageBusy">
            <h3 class="card-title">{{ title }}</h3>
            <a class="btn btn-success float-right" :href="'/user/profile/edit'">
                Edit
            </a>
        </div>
        <div class="card-body">
            <div class="text-center" v-if="isPageBusy">
                <spinner-component></spinner-component>
            </div>

            <b-table-simple bordered>
                <b-tr>
                    <b-td>E-Mail</b-td>
                    <b-td>{{ user.email }}</b-td>
                </b-tr>
                <b-tr>
                    <b-td>Vollständiger Name</b-td>
                    <b-td>{{ user.user_info.full_name }}</b-td>
                </b-tr>
                <b-tr>
                    <b-td>Straße/Nr.</b-td>
                    <b-td>{{ user.user_info.street }}</b-td>
                </b-tr>
                <b-tr>
                    <b-td>PLZ</b-td>
                    <b-td>{{ user.user_info.zip }}</b-td>
                </b-tr>
                <b-tr>
                    <b-td>Ort</b-td>
                    <b-td>{{ user.user_info.city }}</b-td>
                </b-tr>
                <b-tr>
                    <b-td>Geburtstag</b-td>
                    <b-td>{{ user.user_info.birthday }}</b-td>
                </b-tr>
                <b-tr>
                    <b-td>Geburtstag</b-td>
                    <b-td>
                        <img :src="user.user_info.image_url"
                             :alt="user.user_info.full_name">
                    </b-td>
                </b-tr>
            </b-table-simple>

        </div>
    </div>
</template>

<script>
import {get} from "../../api/profile";

export default {
    components: {},
    props:      {
        title: String,
        user:  Object,
    },
    data() {
        return {
            isPageBusy: false,
        }
    },
    methods: {
        async _loadData() {
            // let response = await get('/profile');
            // console.log(response);
        },
    },
    async mounted() {
        console.log(this.user);
        await this._loadData();
    },
    watch: {
        // itemsPerPage: function (val) {
        //     this._loadData(1);
        // }
    }
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
</style>
