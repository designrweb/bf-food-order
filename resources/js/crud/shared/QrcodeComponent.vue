<template>
  <div class="position-relative">
    <div class="d-flex justify-content-center align-items-left flex-column">
      <qrcode-vue :value="value" :size="size" level="H" v-if="value"></qrcode-vue>
      <span v-else>QR-Code not found. Please generate it.</span>
      <div class="row" v-show="entityId">
        <button class="btn btn-warning mb-2 mr-1" @click.prevent="generateCode"><i class="fa fa-redo-alt"></i> Regenerate</button>
        <button class="btn btn-success mb-2 mr-1" @click.prevent="downloadCode" v-if="value"><i class="fa fa-mobile-alt"></i> Download</button>
        <button class="btn btn-primary mb-2"><i class="fa fa-print"></i> Manual</button>
      </div>
    </div>
  </div>
</template>
<script>
import QrcodeVue                    from 'qrcode.vue'
import {generateCode, downloadCode} from "../api/qrCodeRequests";

export default {
  name:       "QrcodeComponent",
  props:      {
    route:    String,
    initial:  String | null,
    entityId: String | Number,
  },
  data() {
    return {
      size:  150,
      value: '',
    }
  },
  components: {
    QrcodeVue,
  },
  methods:    {
    async generateCode() {
      if (window.confirm('Old QR code will be not working anymore. Please print a new one after confirmation.')) {
        let response = await generateCode(this.route + '/' + this.entityId + '/generate-code', []);
        this.value   = response.data.qrcode.qr_code_hash;
      }
    },
    async downloadCode() {
      let response = await downloadCode(this.route + '/' + this.entityId + '/download-code', 'blob');

      let blob      = new Blob([response.data]);
      let link      = document.createElement('a');
      link.href     = window.URL.createObjectURL(blob);
      link.download = "qr_food_order.jpg";
      link.click();
    }
  },
  mounted() {
    this.value = this.initial;
  }
}
</script>