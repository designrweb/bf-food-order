<template>
  <div class="form-group">
    <b-input-group>
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
      </b-form-select>
      <b-input-group-append v-show="Object.keys(options).find(key => options[key].id === this.value)" @click="clear">
        <b-input-group-text>
          <b-icon icon="x"/>
        </b-input-group-text>
      </b-input-group-append>
    </b-input-group>
  </div>
</template>

<script>
export default {
  name:  "SelectFilterComponent",
  props: {
    filterName:         String,
    filterLabel:        String,
    appliedFilterValue: String | Number,
    options:            Array
  },
  data() {
    return {
      value: ''
    }
  },
  methods: {
    clear() {
      this.value = '';
      this.changeHandler();
    },
    changeHandler() {
      let name = this.filterName;
      this.$emit('changeFilter', {[name]: {'filter': this.value, 'type': 'select', 'values': this.options}});
    },
    inputHandler() {
      let name = this.filterName;
      this.$emit('inputFilter', {[name]: {'filter': this.value, 'type': 'select', 'values': this.options}});
    }
  },
  mounted() {
    this.value = this.appliedFilterValue;
  }
}
</script>

<style scoped>

</style>
