<template>
    <div class="d-inline">
        <button class="btn btn-sm btn-danger m-1" @click="onButtonClick">
            <b-icon icon="trash-fill"></b-icon>
        </button>
        <b-overlay :show="busy" no-wrap :fixed="true" :z-index="1135">
            <template v-slot:overlay>
                <spinner-component v-if="isLoading"></spinner-component>
                <div v-else
                     ref="dialog"
                     class="text-center p-3 border border-info">
                    <p>
                        <strong id="form-confirm-label">Are you sure?</strong>
                    </p>
                    <div class="d-flex">
                        <b-button variant="outline-danger" class="mr-3" @click="onCancel">Cancel</b-button>
                        <b-button variant="outline-success" @click="onOK">OK</b-button>
                    </div>
                </div>
            </template>
        </b-overlay>
    </div>
</template>
<script>
    import axios            from "axios";
    import SpinnerComponent from "../SpinnerComponent";

    export default {
        name:       "DeleteButton",
        components: {
            'spinner-component': SpinnerComponent
        },
        data() {
            return {
                busy:      false,
                isLoading: false
            }
        },
        props:      {
            mainRoute: String,
            id:        String | Number,
        },
        methods:    {
            onButtonClick() {
                this.busy = true;
            },
            onCancel() {
                this.busy = false
            },
            deleteItem: async function () {
                this.isLoading = true;
                let response = await axios.post(this.mainRoute + '/' + this.id, {_method: 'delete'});
                try{
                    window.location.href = response['data']['redirect_url'];
                }catch (e) {
                    alert('An error occurred\r\nPlease refresh the page');
                    this.isLoading = false;
                }
            },
            onOK() {
                this.deleteItem();
            }
        }
    }
</script>

<style scoped>

</style>
