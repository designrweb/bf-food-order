<template>
  <b-input-group class="mb-3">
    <date-range-picker
        v-model="value"
        :ref="'filter.'+filterName"
        :single-date-picker="true"
        :auto-apply="true"
        :ranges="false"
        :locale-data="{format: 'yyyy.mm.dd'}"
        @update="inputHandler">
    </date-range-picker>
  </b-input-group>
</template>

<script>
import DateRangePicker from 'vue2-daterange-picker'

import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

export default {
  name:       "DateRangePickerFilterComponent",
  props:      {
    filterName:         String,
    filterLabel:        String,
    appliedFilterValue: Object
  },
  components: {DateRangePicker},
  data() {
    return {
      value: {},
    }
  },
  filters:    {
    date(val) {
      return val ? val.toLocaleString() : ''
    }
  },
  methods:    {
    dateFormat(classes, date) {
      return classes
    },
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
/*>>> div.daterangepicker {*/
/*  position: fixed !important;*/
/*  left: 76% !important;*/
/*}*/

>>> div.daterangepicker.show-ranges {
  min-width: 742px;
}

>>> .daterangepicker .drp-calendar {
  max-width: 300px;
  width: 300px;
}

.slot {
  background-color: #aaaaaa !important;
  padding: 0.5rem !important;
  color: white !important;
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
}

.text-black {
  color: #000000 !important;
}
</style>
