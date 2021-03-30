<template>
    <td :class="tdClass">
        <div class="ordered-items-wrapper text-left">
            <div class="d-block align-items-center" v-if="isHoliday">
              <span class="holiday-marker">Schulfreie Zeit</span>
            </div>
            <div class="d-block align-items-center" v-if="dayItem !== null && !isHoliday">
                <div class="flex-3">
                    <i class="fas fa-info-circle info-button" @click="showItemDescription(dayItem)"></i>
                    <span>{{dayItem.name}}</span>
                </div>
                <div class="flex-1 buttons-block">
                    <i v-if="dayItem.quantity == 1 && isPermitToCancelItem"
                       :class="cancelButtonClassObject"
                       aria-hidden="true"
                       @click="decreaseQuantity(dayItem)"></i>

                    <i v-else-if="dayItem.quantity > 1 && isPermitToCancelItem"
                       :class="minusButtonClassObject"
                       aria-hidden="true"
                       @click="decreaseQuantity(dayItem)"></i>

                    {{dayItem.quantity}}
                    <i v-if="isPermitToAddItem"
                       :class="addButtonClassObject"
                       aria-hidden="true"
                       @click="increaseQuantity(dayItem)"></i>
                    <b-btn
                            v-if="isPermitToCancelItem && dayItem.quantity > 0"
                            size="sm"
                            class="mb-2 item-cancel-button"
                            variant="danger"
                            @click="cancelOrder(dayItem)">
                        stornieren
                    </b-btn>
                </div>
            </div>
        </div>
    </td>
</template>

<script>
    // TODO: rename functions to proper way
    import {
        isPermitToCancelItem,
        isPermitToAddItem
    } from "../../../utils/foodOrderDateHelper";

    export default {
        name:     "OrderedItemsComponent",
        props:    {
            dayItems:             Array,
            menuCategory:         Object,
            dayDate:              String,
            balance:              Number,
            isUserSubsidized:     Boolean,
            subsidizedPercentage: Number,
            isHoliday: Boolean
        },
        data:     () => ({
            dayItem: null,
        }),
        computed: {
            isPermitToCancelItem:    function () {
                return !this.menuCategory.is_ordered && isPermitToCancelItem(this.dayDate);
            },
            isPermitToAddItem:       function () {
                return !this.menuCategory.is_ordered
                    && isPermitToAddItem(this.dayDate)
                    && (
                        this.balance >= this.menuCategory.presaleprice
                        || this._isAllowSubsidization()
                    );
            },
            cancelButtonClassObject: function () {
                return {'fas fa-times quantity-remove-button': true, 'disabled': !this.isPermitToCancelItem}
            },
            minusButtonClassObject:  function () {
                return {'fa fa-minus-square brand-button': true, 'disabled': !this.isPermitToCancelItem}
            },
            addButtonClassObject:    function () {
                return {'fa fa-plus-square brand-button': true, 'disabled': !this.isPermitToAddItem};
            },
            tdClass:                 function () {
                return {
                    'p-2 border':           true,
                    // 'auto-ordered':         this.menuCategory.is_ordered,
                    'ordered-item-success': (this.dayItem !== null && this.dayItem.quantity >= 1)
                };
            }
        },
        methods:  {
            showItemDescription:   function (item) {
                this.$emit('showMenuItemDescription', item);
            },
            increaseQuantity:      function (item) {
                let updatedItem = {...item};
                updatedItem.quantity += 1;
                this._updateItem(updatedItem);
            },
            decreaseQuantity:      function (item) {
                let updatedItem = {...item};
                updatedItem.quantity -= 1;
                this._updateItem(updatedItem);
            },
            cancelOrder:           function (item) {
                let updatedItem      = {...item};
                updatedItem.quantity = 0;
                this._updateItem(updatedItem);
            },
            _updateItem:           function (item) {
                this.$emit('updateOrderItem', item);
            },
            _isAllowSubsidization: function () {
                let isSubsidizedItemOrdered             = false;
                let isMenuCategoryAllowForSubsidization = this.menuCategory.is_allow_for_subsidization;

                for (let dayItemIndex in this.dayItems) {
                    let dayItemData         = this.dayItems[dayItemIndex];
                    isSubsidizedItemOrdered = dayItemData.quantity > 0
                        && dayItemData.is_subsidized;

                    if (isSubsidizedItemOrdered == true) break;
                }

                return isMenuCategoryAllowForSubsidization
                    && this.isUserSubsidized
                    && !isSubsidizedItemOrdered
                    && (this.balance >= this.menuCategory.presaleprice -
                        this.menuCategory.presaleprice * this.subsidizedPercentage / 100);
            }
        },
        watch:    {
            dayItems: {
                handler: function (val, oldVal) {
                    const self     = this;
                    let foundItems = self.dayItems.filter(dayItem => self.menuCategory.id == dayItem.menu_category_id);
                    if (foundItems.length > 0) {
                        self.dayItem = foundItems[0];
                    } else {
                        self.dayItem = null;
                    }
                },
                deep:    true
            },
        }
    }
</script>

<style scoped>
    td {
        vertical-align: top;
        position: relative;
    }

    .ordered-items-wrapper {
        padding-bottom: 25px;
    }

    .brand-button {
        color: #96c11f;
        cursor: pointer;
        opacity: 0.8;
    }

    .brand-button:hover,
    .brand-button:active {
        opacity: 1;
    }

    .quantity-remove-button {
        color: #dc3545;
        cursor: pointer;
    }

    .quantity-remove-button:hover {
        color: #FF6F74;
    }

    .item-cancel-button {
        letter-spacing: .05em;
        padding: 0;
        font-size: 0.7em;
    }

    .buttons-block {
        white-space: nowrap;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        text-align: left !important;
        border-top: 1px solid #eeeeee;
        padding-left: 5px;
    }

    .info-button {
        color: #8b8585;
        cursor: pointer;
        float: right;
    }

    .info-button:hover {
        color: #dfd7d7;
    }

    .ordered-item-success {
        background-color: #e9ffd6;
    }

    .holiday-marker {
      color: #96c11f;
    }
</style>
