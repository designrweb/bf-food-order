<template>
    <div class="form-group">
        <b-form-select
            v-model="value"
            :options="options"
            value-field="id"
            text-field="name"
            @change="changeHandler"
            @input="inputHandler"
            :placeholder="filterLabel"
            :ref="'filter.'+filterName"
        >
          <template #first>
            <b-form-select-option :value="null">-- Please select an option --</b-form-select-option>
          </template>
        </b-form-select>
    </div>
</template>

<script>
    export default {
        name:    "TextFilterComponent",
        props:   {
            filterName:         String,
            filterLabel:        String,
            appliedFilterValue: String,
            options:            Object
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
