<template>
  <div class="position-relative">
    <div class="card-spinner-container" v-if="isLoading">
      <b-spinner class="" type="grow" label="Spinning"></b-spinner>
    </div>
    <div class="d-flex justify-content-center align-items-center flex-column">
      <croppa
          v-model="croppaImage"
          :prevent-white-space="true"
          :show-loading="true"
          :width="300"
          :height="400"
          :initialImage="image"
          :zoom-speed="5"
          :placeholder="''"
          @image-remove="removeImage"
          @loading-end="loadingEndImage">
        <img slot="placeholder" src="/image/placeholder.png"/>
      </croppa>
      <button type="button" class="btn btn-success mt-1" v-if="imageBase64" @click="uploadImage">Upload Image</button>
    </div>
  </div>
</template>

<script>
import {storeImage, removeImage} from "../api/imageUpload";

export default {
  name:    "ImageUploadComponent",
  props:   {
    imageFieldName: String,
    image:          String | null,
    entityId:       String | Number,
    entityName:     String,
  },
  data:    () => ({
    isLoading:   false,
    imageBase64: false,
    dataUpload:  {},
    croppaImage: {}
  }),
  methods: {
    loadingEndImage() {
      this.imageBase64 = this.croppaImage.generateDataUrl();

      this.emitChange();
    },
    async uploadImage() {
      this.isLoading = true;

      let response = await storeImage(this.dataUpload);

      if (response.data.success === false) {
        this._showToastError(response.data.message);
      } else {
        this._showToastSuccess(response.data.message);
      }

      this.isLoading = false;
    },
    async removeImage() {
      this.isLoading = true;

      if (this.entityId) {
        let response = await removeImage(this.dataUpload);

        if (response.data.success === false) {
          this._showToastError(response.data.message);
        } else {
          this.imageBase64 = null;
          this.emitChange({[this.imageFieldName]: null});
          this._showToastSuccess(response.data.message);
        }
      }

      this.isLoading = false;
    },
    _showToastSuccess(message = '', title = 'Erfolg') {
      this.$bvToast.toast(message, {
        toaster:       'b-toaster-bottom-left',
        title:         title,
        variant:       'success',
        autoHideDelay: 3000,
      });
    },
    _showToastError(message = '', title = 'Error') {
      this.$bvToast.toast(message, {
        toaster:       'b-toaster-bottom-left',
        title:         title,
        variant:       'danger',
        autoHideDelay: 3000,
      });
    },
    emitChange(extraData = {}) {
      this.dataUpload = {
        '_imageBase64':    this.imageBase64,
        '_entityId':       this.entityId,
        '_entityName':     this.entityName,
        '_imageFieldName': this.imageFieldName,
      };

      this.dataUpload = {...this.dataUpload, ...extraData}

      this.$emit('changed', this.dataUpload);
    }
  },
  created() {
    this.emitChange();
  },

}
</script>

<style scoped>
.card-spinner-container {
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: 99;
  background: rgba(255, 255, 255, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

>>> .croppa-container {
  align-self: center;
}

>>> .croppa-container canvas {
  width: 100% !important;
  height: auto !important;
  max-width: 300px !important;
}

.card-spinner-container span {
  color: #96c11f;
}
</style>
