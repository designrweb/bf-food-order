<template>
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <div>Bislang sind keine Kinder angelegt.</div>

            <div class="mt-2">
                <create-consumer-button :mainRoute="main_route + '/create'"
                                        :label="'+ Kind anlegen'"></create-consumer-button>
            </div>
        </div>
    </div>
</template>

<script>
import {CreateConsumerButton} from "./grid-buttons";

export default {
    name:       "NoConsumersComponent",
    components: {
        'create-consumer-button': CreateConsumerButton,
    },
    props:      {
        main_route: String
    },
}
</script>

<style scoped>

</style>