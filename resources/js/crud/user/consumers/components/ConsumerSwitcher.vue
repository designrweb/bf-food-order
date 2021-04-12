<template>
    <div>
        <b-dropdown
            id="consumer-switcher-btn"
            v-if="consumers.length !== 0"
            split-variant="outline-success"
            variant="success"
            :text="selected_consumer ? selectedConsumerFullName : 'Verbraucher wählen'"
            menu-class="consumer-switcher-menu"
            toggle-class="consumer-switcher-button"
            class="m-3 22222222">
            <b-dropdown-item
                class="consumer-switcher-list"
                v-if="selected_consumer && selected_consumer.id !== consumer.id"
                @click="switchCompany(consumer.id)"
                href="#" v-for="consumer in consumers" :key="consumer.id">
                <span>{{ consumer.full_name }}</span>
            </b-dropdown-item>
            <b-dropdown-item :href="main_route + '/create'">
                <span class="add-consumer-btn">+ Kind anlegen</span>
            </b-dropdown-item>
        </b-dropdown>
        <b-overlay v-else :show="isLoading" rounded opacity="0.6" spinner-small
                   class="d-inline-blocks">
            <b-dropdown-item :href="main_route + '/create'" :disabled="!isProfileCompleted">
                <span class="add-consumer-btn">+ Kind anlegen</span>
            </b-dropdown-item>
        </b-overlay>
    </div>
</template>

<script>
import {switchConsumer} from "../../../api/crudRequests";
import {get}            from "../../../api/profile";

export default {
    name:  "ConsumerSwitcher",
    props: {
        consumers:         Array,
        selected_consumer: Object,
        main_route:        String
    },
    data() {
        return {
            isProfileCompleted: false,
            isLoading:          false,
        }
    },
    computed: {
        selectedConsumerFullName() {
            return this.selected_consumer ? this.selected_consumer.full_name : null;
        }
    },
    methods:  {
        async switchCompany(id) {
            await switchConsumer(this.main_route + '/' + id + '/switch-consumer');

            location.reload();
        },
        async _isProfileCompleted() {
            this.isLoading = true;

            let data                = await get('/user/profile/completed-profile');
            this.isProfileCompleted = data.data;

            this.isLoading = false;
        },
    },
    async mounted() {
        await this._isProfileCompleted();
    },
}
</script>

<style lang="scss">
.add-consumer-btn {
    color: var(--main-theme-color) !important
}
</style>