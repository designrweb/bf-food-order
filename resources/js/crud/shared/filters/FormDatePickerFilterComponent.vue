<template>
  <div class="form-group">
    <b-input-group>
      <b-input-group-prepend>
        <b-form-datepicker
            v-model="value"
            @input="inputHandler"
            reset-button
            button-only
            :aria-controls="filterName + '_date_picker-input'"
            start-weekday="1"
            :date-format-options="{ year: 'numeric', month: '2-digit', day: '2-digit' }"
            locale="de"
            @context="onContext"
        ></b-form-datepicker>
      </b-input-group-prepend>
      <b-form-input
          :ref="'filter.'+filterName"
          :id="filterName + '_date_picker-input'"
          v-model="valueInput"
          type="text"
          :placeholder="filterLabel"
          autocomplete="off"
      ></b-form-input>
    </b-input-group>
  </div>
</template>

<script>
export default {
  name:  "FormDatePickerFilterComponent",
  props: {
    filterName:         String,
    filterLabel:        String,
    appliedFilterValue: String
  },
  data() {
    return {
      value:      '',
      valueInput: '',
    }
  },
  methods: {
    onContext(ctx) {
      this.valueInput = ctx.selectedDate ? ctx.selectedFormatted : '';
    },
    clear() {
      this.value = '';
      this.changeHandler();
    },
    changeHandler() {
      let name = this.filterName;
      this.$emit('changeFilter', {[name]: this.value});
    },
    inputHandler() {
      let name = this.filterName;
      this.$emit('changeFilter', {[name]: this.value});
    }
  },
  mounted() {
    this.value = this.appliedFilterValue;
  }
}
</script>

<style scoped>

</style>
