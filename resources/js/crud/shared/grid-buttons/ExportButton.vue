<template>
  <div class="float-right m-1">
    <b-overlay :show="isBusy" rounded="sm">
      <b-dropdown id="dropdown-header" right text="Export" variant="outline-danger" class="m-2">
        <b-dropdown-header id="dropdown-header-label">
          Export Page Data
        </b-dropdown-header>
        <b-dropdown-item-button aria-describedby="dropdown-header-label" @click="handleExport('Html')">
          <i class="fas fa-file-code"></i> HTML
        </b-dropdown-item-button>
        <b-dropdown-item-button aria-describedby="dropdown-header-label" @click="handleExport('Csv')">
          <i class="fas fa-file-csv"></i> CSV
        </b-dropdown-item-button>
        <b-dropdown-item-button aria-describedby="dropdown-header-label" @click="handleExport('Xlsx')">
          <i class="fas fa-file-excel"></i> Excel
        </b-dropdown-item-button>
        <b-dropdown-item-button aria-describedby="dropdown-header-label" @click="handleExport('Mpdf')">
          <i class="fas fa-file-pdf"></i> PDF
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
    allowTypes: [
      {
        name: 'HTML',
        allow: true,
      },
      {
        name: 'CSV',
        allow: true,
      },
      {
        name: 'Excel',
        allow: true,
      },
      {
        name: 'PDF',
        allow: true,
      },
    ],
    main_route: String
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
