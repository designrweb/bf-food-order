<template>
    <div class="card">
        <div class="card-header" v-if="!isPageBusy">
            <h3 class="card-title">{{ title }}</h3>
            <a class="btn btn-success float-right" :href="'/user/profile/edit'">
                Aktualisieren
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
                    <b-td>Anrede</b-td>
                    <b-td>{{ getSalutation(user.user_info.salutation) }}</b-td>
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
            </b-table-simple>
        </div>

    </div>
</template>

<script>
export default {
    components: {},
    props:      {
        title:            String,
        user:             Object,
        salutations_list: Array
    },
    data() {
        return {
            isPageBusy: false,
        }
    },
    methods: {
        getSalutation(id) {
            let item = _.find(this.salutations_list, salutation => id === salutation.id);

            return item ? item.name : '---'
        }
    },
    mounted() {
        console.log(this.salutations_list);
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
