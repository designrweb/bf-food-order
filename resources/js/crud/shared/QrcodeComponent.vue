<template>
    <div class="position-relative">
        <div class="d-flex justify-content-center align-items-left flex-column">
            <qrcode-vue :value="value" :size="size" level="H" v-if="value"></qrcode-vue>
            <span v-else>QR-Code nicht gefunden. Bitte generieren Sie es.</span>
            <div class="row" v-show="entityId">
                <button class="btn btn-warning mb-2 mr-1"
                        :disabled="isPageBusy"
                        @click.prevent="generateCode">
                    <i class="fa fa-redo-alt" v-if="!isPageBusy"></i>
                    <i class="fa fa-spinner fa-spin" v-if="isPageBusy"></i>
                    Regenerieren
                </button>
                <button class="btn btn-success mb-2 mr-1"
                        @click.prevent="downloadCode"
                        :disabled="isPageBusy"
                        v-if="value">
                    <i class="fa fa-mobile-alt" v-if="!isPageBusy"></i>
                    <i class="fa fa-spinner fa-spin" v-if="isPageBusy"></i>
                    Herunterladen
                </button>
                <button class="btn btn-primary mb-2"
                        :disabled="isPageBusy"
                        @click.prevent="downloadPdf">
                    <i class="fa fa-print" v-if="!isPageBusy"></i>
                    <i class="fa fa-spinner fa-spin" v-if="isPageBusy"></i>
                     Druckansicht
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import QrcodeVue                                    from 'qrcode.vue'
import {generateCode, downloadCode, downloadManual} from "../api/qrCodeRequests";

export default {
    name:  "QrcodeComponent",
    props: {
        route:    String,
        initial:  String | null,
        entityId: String | Number,
    },
    data() {
        return {
            size:  150,
            value: '',
            isPageBusy: false
        }
    },
    components: {
        QrcodeVue,
    },
    methods:    {
        async generateCode() {
            this.isPageBusy = true;
            if (window.confirm('Old QR code will be not working anymore. Please print a new one after confirmation.')) {
                let response = await generateCode(this.route + '/' + this.entityId + '/generate-code', []);
                this.value   = response.data.qr_code.qr_code_hash;
            }
            this.isPageBusy = false;
        },
        async downloadCode() {
            this.isPageBusy = true;
            let response = await downloadCode(this.route + '/' + this.entityId + '/download-code', 'blob');

            let blob      = new Blob([response.data]);
            let link      = document.createElement('a');
            link.href     = window.URL.createObjectURL(blob);
            link.download = "qr_food_order.jpg";
            link.click();
            this.isPageBusy = false;
        },
        async downloadPdf() {
            this.isPageBusy = true;
            let response = await downloadManual(this.route + '/' + this.entityId + '/download-manual', 'blob');

            let blob      = new Blob([response.data]);
            let link      = document.createElement('a');
            link.href     = window.URL.createObjectURL(blob);
            link.download = "qr_food_order.pdf";
            link.click();
            this.isPageBusy = false;
        }
    },
    mounted() {
        this.value = this.initial;
    }
}
</script>
