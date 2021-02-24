<template>
    <div class="position-relative">
        <div class="card-spinner-container" v-if="isLoading">
            <b-spinner class="" type="grow" label="Spinning"></b-spinner>
        </div>
        <div class="d-flex justify-content-center align-items-center flex-column">
            <croppa
                    v-model="croppaImage"
                    :prevent-white-space="true"
                    :width="300"
                    :height="400"
                    :initialImage="initialImageUrl"
                    :zoom-speed="5"
                    :placeholder="''"
                    @image-remove="removeImage"
                    @file-choose="isCanUpload = true"
            >
                <img slot="placeholder" src="/image/placeholder.png"/>
            </croppa>
            <button type="button" class="btn btn-success mt-1" :disabled="!isCanUpload" @click="uploadImage">
                Upload Image
            </button>
        </div>
    </div>
</template>

<script>
    // import {
    //     storeConsumerImage,
    //     removeConsumerImage
    // } from "../../../crud/api/imageUpload";

    export default {
        name:    "ConsumerImageUploadForm",
        props:   {
            initialImageUrl:  String,
            initialImageName: String,
            consumerId:      String,
        },
        data:    () => ({
            isLoading:      false,
            isCanUpload: false,
            imageName:      null,
            croppaImage:    {}
        }),
        methods: {
            async uploadImage() {
                this.isLoading  = true;
                let imageBase64 = this.croppaImage.generateDataUrl();
                let response    = await storeConsumerImage({
                    'UploadForm': {'imageBase64': imageBase64},
                    'consumerId': this.consumerId,
                });

                if (response.data.success == 0) {
                    this._showToastError(response.data.error);
                } else {
                    this.imageName = response.data.fileName;
                    this.isCanUpload = false;
                    this._showToastSuccess('Bild hochgeladen');
                }
                this.isLoading = false;
            },
            async removeImage() {
                this.isLoading = true;

                if (this.imageName != '') {
                    let response = await removeConsumerImage(this.consumer_id, this.imageName);
                    if (response.data.success == 0) {
                        this._showToastError(response.data.error);
                    } else {
                        this.imageName = null;
                        this._showToastSuccess('Bild entfernt');
                    }
                }
                this.isCanUpload = false;
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
        },
        created() {
            this.imageName = this.initialImageName;
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
