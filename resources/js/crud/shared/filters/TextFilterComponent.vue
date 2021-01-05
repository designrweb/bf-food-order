<template>
  <div class="form-group">
    <b-input-group>
      <b-form-input
          v-model="value"
          @change="changeHandler"
          @input="inputHandler"
          autocomplete="off"
          :placeholder="filterLabel"
          :ref="'filter.'+filterName"
      ></b-form-input>
      <b-input-group-append v-show="this.value" @click="clear">
        <b-input-group-text>
          <b-icon icon="x"/>
        </b-input-group-text>
      </b-input-group-append>
    </b-input-group>
  </div>
</template>

<script>
export default {
  name:  "TextFilterComponent",
  props: {
    filterName:         String,
    filterLabel:        String,
    appliedFilterValue: String
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
