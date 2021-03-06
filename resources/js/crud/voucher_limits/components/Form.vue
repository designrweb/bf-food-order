<template>
  <div class="position-relative">
    <div class="card-spinner-container" v-if="isLoading">
      <b-spinner class="" variant="warning" type="grow" label="Spinning"></b-spinner>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ title }}</h3>
        <b-row class="menu-underlined-block pt-12">
          <b-col cols="12" class="text-right">
            <b-btn variant="primary" @click="store">Speichern</b-btn>
          </b-col>
        </b-row>
      </div>
      <div class="card-body text-center position-relative overflow-auto">
        <b-row>
          <b-col class="py-0">
            <table class="food-order-schedule w-100">
              <thead>
              <tr>
                <day-title-component
                    title="Menülinie"
                ></day-title-component>
                <day-title-component
                    :title="getDayTitle(0)"
                ></day-title-component>
                <day-title-component
                    :title="getDayTitle(1)"
                ></day-title-component>
                <day-title-component
                    :title="getDayTitle(2)"
                ></day-title-component>
                <day-title-component
                    :title="getDayTitle(3)"
                ></day-title-component>
                <day-title-component
                    :title="getDayTitle(4)"
                ></day-title-component>
              </tr>
              </thead>
              <tbody>
              <tr v-for="menuCategory in menu_categories">
                <menu-categories-component
                    :menu-category="menuCategory"
                ></menu-categories-component>
                <ordered-items-component
                    :menuId="menuCategory.id"
                    :day="0"
                    @updateOrderItem=updateOrderItem($event,0,menuCategory.id)
                    :dayValue="getDateValue(menuCategory, 0)"
                ></ordered-items-component>
                <ordered-items-component
                    :menuId="menuCategory.id"
                    :day="1"
                    @updateOrderItem=updateOrderItem($event,1,menuCategory.id)
                    :dayValue="getDateValue(menuCategory, 1)"
                ></ordered-items-component>
                <ordered-items-component
                    :menuId="menuCategory.id"
                    :day="2"
                    @updateOrderItem=updateOrderItem($event,2,menuCategory.id)
                    :dayValue="getDateValue(menuCategory, 2)"
                ></ordered-items-component>
                <ordered-items-component
                    :menuId="menuCategory.id"
                    :day="3"
                    @updateOrderItem=updateOrderItem($event,3,menuCategory.id)
                    :dayValue="getDateValue(menuCategory, 3)"
                ></ordered-items-component>
                <ordered-items-component
                    :menuId="menuCategory.id"
                    :day="4"
                    @updateOrderItem=updateOrderItem($event,4,menuCategory.id)
                    :dayValue="getDateValue(menuCategory, 4)"
                ></ordered-items-component>
              </tr>
              </tbody>
            </table>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>

<script>
import {storeItemList} from "../../api/voucherLimits";

import moment from 'moment';

import OrderedItemsComponent        from "./OrderedItemsComponent";
import DayTitleComponent            from "./DayTitleComponent";
import MenuCategoriesItemsComponent from "./MenuCategoriesItemsComponent";

export default {
  name:       "Form",
  components: {
    'ordered-items-component':   OrderedItemsComponent,
    'day-title-component':       DayTitleComponent,
    'menu-categories-component': MenuCategoriesItemsComponent,
  },
  computed:   {},
  props:      {
    menu_categories: {},
    weeklylist:      Object | Array,
    title: String
  },
  data:       () => ({
    isLoading: true,
  }),
  methods:    {
    /**
     * Generate day title
     *
     * @param dayIndex
     * @returns {*}
     */
    getDayTitle: function (dayIndex) {
      let _date = this.getFirstDay();
      _date.setDate(_date.getDate() + dayIndex);
      return moment(_date).format('dd');
    },
    /**
     * Store all voucher-limit items
     * @returns void
     */
    store:        async function () {
      this.isLoading = true;
      try {
        await storeItemList('/admin/voucher-limits', this.weeklylist);
      } catch (e) {
        this._showToastError(e.toString());
      }
      this.isLoading = false;
    },
    getDateValue: function (menuCategory, dayNumber) {
      if (!(dayNumber in this.weeklylist)) return 0;

      if (!(menuCategory.id in this.weeklylist[dayNumber])) return 0;

      return parseInt(this.weeklylist[dayNumber][menuCategory.id]);
    },
    /**
     * Returns the first day of current week
     */
    getFirstDay: function () {
      let _today = new Date();
      _today.setHours(0, 0, 0, 0);
      _today   = new Date(_today);
      let day  = _today.getDay(),
          diff = _today.getDate() - day + (day == 0 ? -6 : 1); // adjust when day is sunday
      return new Date(_today.setDate(diff));
    },
    /**
     * Update order item
     *
     * @param updatedItem
     * @param selectedDayIndex
     * @param menuId
     * @return void
     */
    updateOrderItem: async function (updatedItem, selectedDayIndex, menuId) {
      this.isLoading = true;

      if (!(selectedDayIndex in this.weeklylist)) {
        this.weeklylist[selectedDayIndex] = {};
      }

      this.weeklylist[selectedDayIndex][menuId] = updatedItem;
      this.isLoading                            = false;
    },
    _showToastError(message = '', title = 'Error') {
      this.$bvToast.toast(message, {
        toaster:       'b-toaster-bottom-left',
        title:         title,
        variant:       'danger',
        autoHideDelay: 3000,
      });
    },
  },
  created() {
    moment.locale('de');
  },
  async mounted() {
    this.isLoading = true;
    this.isLoading = false;
  },
}
</script>

<style scoped>
table {
  border-spacing: 5px;
  border-collapse: separate;
}

.card-spinner-container {
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: 99;
  background: rgba(255, 255, 255, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.food-order-schedule {
  border-top: 2px solid;
  border-top-color: #96c11f;
}

.btn-brand {
  background-color: #96c11f;
  color: white;
  border-color: #96c11f;
}

.btn-brand:hover, .btn-brand:focus, .btn-brand:not(:disabled):not(.disabled):active {
  background-color: white;
  color: #96c11f;
  border-color: #96c11f;
  box-shadow: 0 0 0 0.2rem rgba(150, 193, 31, 0.5);
}

>>> .spinner-grow {
  color: #96c11f !important;
}

>>> .flex-3 {
  flex: 3;
}

>>> .flex-1 {
  flex: 1;
}
</style>
