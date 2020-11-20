<template>
  <div class="form-group">
    <b-form-input
        v-model="value"
        @change="changeHandler"
        @input="inputHandler"
        autocomplete="off"
        @keypress="isNumber($event)"
        :placeholder="filterLabel"
        :ref="'filter.'+filterName"
    ></b-form-input>
  </div>
</template>

<script>
export default {
  name:    "NumberFilterComponent",
  props:   {
    filterName:         String,
    filterLabel:        String,
    appliedFilterValue: Number | String
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
    },
    isNumber: function (evt) {
      evt          = (evt) ? evt : window.event;
      let charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();
      } else {
        return true;
      }
    }
  },
  mounted() {
    this.value = this.appliedFilterValue;
  }
}
</script>

<style scoped>

</style>
