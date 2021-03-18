<template>
    <div>
        <b-dropdown
            v-if="consumers.length !== 0"
            split-variant="outline-success"
            variant="success"
            :text="selected_consumer ? selectedConsumerFullName : 'Verbraucher wählen'"
            class="m-3">
            <b-dropdown-item
                v-if="selected_consumer && selected_consumer.id !== consumer.id"
                @click="switchCompany(consumer.id)"
                href="#" v-for="consumer in consumers" :key="consumer.id">
                <span>{{ consumer.full_name }}</span>
            </b-dropdown-item>
            <b-dropdown-item :href="main_route + '/create'">
                <span class="add-consumer-btn">+ Kunde Erstellen</span>
            </b-dropdown-item>
        </b-dropdown>
        <b-dropdown-item :href="main_route + '/create'" v-else>
            <span class="add-consumer-btn">+ Kunde Erstellen</span>
        </b-dropdown-item>
    </div>
</template>

<script>
import {switchConsumer} from "../../../api/crudRequests";

export default {
    name:     "ConsumerSwitcher",
    props:    {
        consumers:         Array,
        selected_consumer: Object,
        main_route:        String
    },
    computed: {
        selectedConsumerFullName() {
            return this.selected_consumer ? this.selected_consumer.full_name : null;
        }
    },
    methods: {
        async switchCompany(id) {
            await switchConsumer(this.main_route + '/' + id + '/switch-consumer');

            location.reload();
        }
    }
}
</script>

<style lang="scss">
.add-consumer-btn {
    color: var(--main-theme-color) !important
}
</style>