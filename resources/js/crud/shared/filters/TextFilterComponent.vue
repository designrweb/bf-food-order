<template>
    <div class="form-group">
        <b-form-input
            v-model="value"
            @change="changeHandler"
            @input="inputHandler"
            autocomplete="off"
            :placeholder="filterLabel"
            :ref="'filter.'+filterName"
        ></b-form-input>
    </div>
</template>

<script>
    export default {
        name:    "TextFilterComponent",
        props:   {
            filterName:         String,
            filterLabel:         String,
            appliedFilterValue: String
        },
        data() {
            return {
                value: ''
            }
        },
        methods: {
            changeHandler() {
                let name = this.filterName;
                this.$emit('changeFilter', {[name]: this.value});
            },
            inputHandler() {
                let name = this.filterName;
                this.$emit('inputFilter', {[name]: this.value});
            }
        },
        mounted() {
            this.value = this.appliedFilterValue;
        }
    }
</script>

<style scoped>

</style>
