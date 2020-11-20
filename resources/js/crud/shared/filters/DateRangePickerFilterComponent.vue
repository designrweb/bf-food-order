<template>
  <b-input-group class="mb-3">
    <date-range-picker
        class="date-range-picker"
        v-model="value"
        @toggle="togglePicker"
        :ranges="false"
        :auto-apply="true"
        :ref="'filter.'+filterName"
        :opens="'left'"
        :locale-data="{format: 'yyyy/mm/dd'}">
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
      value:  {},
    }
  },
  filters:    {
    date(val) {
      return val ? val.toLocaleString() : ''
    }
  },
  methods:    {
    togglePicker(show) {
      if (show === true) {
        setTimeout(function () {
          let input                    = $('.date-range-picker');
          let initialTop               = input.offset().top;
          let pickerElement            = $('div.daterangepicker');
          let initialDocumentScrollTop = $(document).scrollTop();
          let initialDiffTop           = (initialTop - initialDocumentScrollTop);
          pickerElement.css('top', initialDiffTop + 40);

          let offset = pickerElement.offset().top;

          document.onscroll = function (e) {
            let documentScroll = $(document).scrollTop();
            let diff           = (offset - documentScroll);
            pickerElement.css('top', diff);
          };
        }, 1)
      }
    },
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
>>> div.daterangepicker {
  position: fixed !important;
  /*left: 76% !important;*/
  right: 119px !important;
}

>>> div.daterangepicker.show-ranges {
  min-width: 742px;
}

>>> .daterangepicker .drp-calendar {
  max-width: 300px;
  width: 300px;
}

>>> .reportrange-text {
  width: 215px !important;
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
