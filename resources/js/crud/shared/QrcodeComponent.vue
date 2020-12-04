<template>
  <div class="position-relative">
    <div class="d-flex justify-content-center align-items-center flex-column">
      <qrcode-vue :value="value" :size="size" level="H"></qrcode-vue>
      <div class="row" v-show="entityId">
        <button class="btn btn-warning mb-2 mr-1" @click.prevent="generateCode"><i class="fa fa-redo-alt"></i> Regenerate</button>
        <button class="btn btn-success mb-2 mr-1" @click.prevent="downloadCode"><i class="fa fa-mobile-alt"></i> Download</button>
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
      size:  300,
      value: '',
    }
  },
  components: {
    QrcodeVue,
  },
  methods:    {
    async generateCode() {
      let response = await generateCode(this.route + '/' + this.entityId + '/generate-code', []);
      this.value   = response.data.qrcode.qr_code_hash;
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