<template>
    <div>
        <back-button-component :route="main_route"></back-button-component>
        <div class="card" v-if="is_consumers_exits">
            <div class="text-center" v-if="isPageBusy">
                <spinner-component></spinner-component>
            </div>

            <div class="card-header" v-if="!isPageBusy">
                <div class="row">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title">{{ title }}</h3>
                    </div>
                </div>

            </div>
            <div class="card-body" v-if="!isPageBusy && resource">
                <qr-code-component
                    :entity-id="resource.consumer_id"
                    :initial="resource.qr_code_hash"
                    :route="main_route"/>
            </div>
        </div>

        <no-consumers-component :main_route="main_route" v-else/>
    </div>
</template>

<script>
import QrcodeComponent      from "../../../shared/QrcodeComponent";
import BackButtonComponent  from "../../../shared/BackButtonComponent";
import SpinnerComponent     from "../../../shared/SpinnerComponent";
import NoConsumersComponent from "../../../shared/NoConsumersComponent";

export default {
    components: {
        'spinner-component':      SpinnerComponent,
        'qr-code-component':      QrcodeComponent,
        'back-button-component':  BackButtonComponent,
        'no-consumers-component': NoConsumersComponent,
    },
    props:      {
        main_route:         String,
        resource:           Object,
        is_consumers_exits: Boolean,
        title:              String
    },
    data() {
        return {
            isPageBusy: false,
        }
    },
    mounted() {
        console.log(this.resource);
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

.card-title {
    font-size: 1.75rem;
}

.action-buttons {
    text-align: right;
}

</style>
