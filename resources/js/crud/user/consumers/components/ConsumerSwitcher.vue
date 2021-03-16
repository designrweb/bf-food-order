<template>
    <div v-if="consumers.length !== 0">
        <b-dropdown
            split
            split-variant="outline-success"
            variant="success"
            :text="selected_consumer ? selectedConsumerFullName : 'Verbraucher wählen'"
            class="m-3">
            <b-dropdown-item
                :disabled="selected_consumer && selected_consumer.id === consumer.id"
                @click="switchCompany(consumer.id)"
                href="#" v-for="consumer in consumers" :key="consumer.id">
                <span>{{ consumer.full_name }}</span>
            </b-dropdown-item>
        </b-dropdown>
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
    mounted() {
        console.log(this.consumers);
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
.dropdown-item.disabled, .dropdown-item:disabled {
    color: #6c757d !important;
}
</style>