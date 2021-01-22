<template>
  <div class="float-right m-1">
    <b-overlay :show="isBusy" rounded="sm">
      <div class="dropdown b-dropdown m-2 btn-group">
        <b-button variant="outline-secondary" v-if="!isExpanded" @click="expand"><i class="fas fa-expand"></i> All</b-button>
        <b-button variant="outline-secondary" @click="expand" v-else><i class="fas fa-compress"></i> Page</b-button>
      </div>
    </b-overlay>
  </div>
</template>

<script>

import {exportCall} from "../../api/exportRequest";

export default {
  name:  "ShowAllButton",
  props: {
    itemsPerPage: Number,
    total:        Number
  },
  data() {
    return {
      isExpanded: false,
      isBusy:     false,
    }
  },
  methods: {
    async expand() {
      this.isBusy = true;

      let newItemsPerPage = this.isExpanded ? 10 : this.total;

      await this.$emit('update:itemsPerPage', newItemsPerPage);

      this.isExpanded = !this.isExpanded;
      this.isBusy     = false;
    }
  }
};
</script>
