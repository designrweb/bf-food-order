<template>
  <div class="form-group">
    <date-picker
        v-model="value"
        valueType="format"
        format="DD.MM.YYYY"
        :lang="lang"
        @clear="clear"
        @change="changeHandler"
        input-class="form-control"
    ></date-picker>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/de';

export default {
  name:       "FormDatePickerFilterComponent",
  components: {
    DatePicker
  },
  props:      {
    filterName:         String,
    filterLabel:        String,
    appliedFilterValue: String
  },
  data() {
    return {
      value:      '',
      lang:       {
        formatLocale:    {
          firstDayOfWeek: 1,
        },
        monthBeforeYear: false,
      },
    }
  },
  methods: {
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

.mx-datepicker {
  width: 100% !important;
}
</style>
