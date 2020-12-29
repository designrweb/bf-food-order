<template>
  <div class="float-right m-1">
    <b-overlay :show="isBusy" rounded="sm">
      <b-dropdown id="dropdown-header" right text="Export" variant="outline-danger" class="m-2">
        <b-dropdown-header id="dropdown-header-label">
          Export Page Data
        </b-dropdown-header>
        <b-dropdown-item-button v-for="(item, index) in formats" v-if="item.allow" :key="index" aria-describedby="dropdown-header-label" @click="handleExport(item.type)">
          <i :class="item.icon"></i> {{ item.name }}
        </b-dropdown-item-button>
      </b-dropdown>
    </b-overlay>
  </div>
</template>

<script>

import {exportCall} from "../../api/exportRequest";

export default {
  name:    "ExportButton",
  props:   {
    filters:    {},
    sort:       {},
    main_route: String,
    formats:    {
      type:     Array,
      required: false,
      default:  [
        {
          type:  'Html',
          icon:  'fas fa-file-code',
          name:  'HTML',
          allow: true,
        },
        {
          name:  'CSV',
          icon:  'fas fa-file-csv',
          type:  'Csv',
          allow: true,
        },
        {
          name:  'Excel',
          icon:  'fas fa-file-excel',
          type:  'Xlsx',
          allow: true,
        },
        {
          name:  'PDF',
          icon:  'fas fa-file-pdf',
          type:  'Mpdf',
          allow: true,
        },
      ]
    }
  },
  data() {
    return {
      isBusy: false,
    }
  },
  methods: {
    async handleExport(type) {
      this.isBusy = true;

      let response = await exportCall(this.main_route, this.filters, this.sort, 'blob', type);

      let blob      = new Blob([response.data]);
      let link      = document.createElement('a');
      link.href     = window.URL.createObjectURL(blob);
      link.download = 'data.' + type.toLowerCase();
      link.click();

      this.isBusy = false;
    }
  }
};
</script>
