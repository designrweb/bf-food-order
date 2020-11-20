<template>
    <div class="form-group">
        <b-form-select
            v-model="value"
            :options="options"
            @change="changeHandler"
            @input="inputHandler"
            :placeholder="filterLabel"
            :ref="'filter.'+filterName"
        ></b-form-select>
    </div>
</template>

<script>
    export default {
        name:    "TextFilterComponent",
        props:   {
            filterName:         String,
            filterLabel:        String,
            appliedFilterValue: String,
            options:            Array
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
