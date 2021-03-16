<template>
    <div class="position-relative">
        <div class="card-spinner-container" v-if="isLoading">
            <b-spinner class="" variant="warning" type="grow" label="Spinning"></b-spinner>
        </div>
        <div class="card">
            <div class="card-header">
                <b-row class="menu-underlined-block pt-12">
                    <!--                    <b-col cols="12" md="6">-->
                    <!--                        <button :class="{-->
                    <!--                                  'btn btn-sm mb-2' : true,-->
                    <!--                                  'btn-outline-brand': !isAutoordering,-->
                    <!--                                  'btn-brand': isAutoordering,-->
                    <!--                                  }"-->

                    <!--                                @click="updateAutoOrderStatus">-->
                    <!--                            {{isAutoordering ? 'Klicken Sie hier, um die automatische Bestellung zu deaktivieren' : 'Klicken Sie hier, um automatische Bestellungen zu aktivieren'}}-->
                    <!--                        </button>-->
                    <!--                        <p :class="{-->
                    <!--                        'fs-12 color-grey': true,-->
                    <!--                        'mb-0':isAutoordering-->
                    <!--                        }">{{isAutoordering ? 'Alle Bestellungen werden am Freitag um 13.00 Uhr aufgegeben.' :-->
                    <!--                            ''}}</p>-->
                    <!--                    </b-col>-->
                    <!--                    <b-col cols="12" md="6" class="text-right">-->

                    <b-col cols="12" md="6" class="text-right">
                        <span>
                            <button
                                class="btn btn-sm mb-2 btn-outline-brand"
                                @click="getPreviousWeek">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            </button>
                        </span>
                        <span class="fs-26 font-weight-medium">{{ firstWeekDay }} - {{ lastWeekDay }}</span>
                        <span>
                   <button class="btn btn-sm mb-2 btn-outline-brand"
                           @click="getNextWeek">
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                  </button>
              </span>
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
                            <tr v-for="menuCategory in menuCategories">
                                <menu-categories-component
                                    :menu-category="menuCategory"
                                    @updateAutoOrderStatus="updateAutoOrderStatusOld"
                                ></menu-categories-component>
                                <ordered-items-component
                                    @updateOrderItem=updateOrderItem($event,0)
                                    @showMenuItemDescription="setMenuItemDescription"
                                    :day-items="weeklyList[0]"
                                    :menu-category="menuCategory"
                                    :day-date="weekTitles[0]"
                                    :balance="balance"
                                    :isUserSubsidized="isSubsidized"
                                    :subsidizedPercentage="getSubsidizationPercentage(menuCategory)"
                                    :isHoliday="isHoliday(weekTitles[0])"
                                ></ordered-items-component>
                                <ordered-items-component
                                    @updateOrderItem=updateOrderItem($event,1)
                                    @showMenuItemDescription="setMenuItemDescription"
                                    :day-items="weeklyList[1]"
                                    :menu-category="menuCategory"
                                    :day-date="weekTitles[1]"
                                    :balance="balance"
                                    :isUserSubsidized="isSubsidized"
                                    :subsidizedPercentage="getSubsidizationPercentage(menuCategory)"
                                    :isHoliday="isHoliday(weekTitles[1])"
                                ></ordered-items-component>
                                <ordered-items-component
                                    @updateOrderItem=updateOrderItem($event,2)
                                    @showMenuItemDescription="setMenuItemDescription"
                                    :day-items="weeklyList[2]"
                                    :menu-category="menuCategory"
                                    :day-date="weekTitles[2]"
                                    :balance="balance"
                                    :isUserSubsidized="isSubsidized"
                                    :subsidizedPercentage="getSubsidizationPercentage(menuCategory)"
                                    :isHoliday="isHoliday(weekTitles[2])"
                                ></ordered-items-component>
                                <ordered-items-component
                                    @updateOrderItem=updateOrderItem($event,3)
                                    @showMenuItemDescription="setMenuItemDescription"
                                    :day-items="weeklyList[3]"
                                    :menu-category="menuCategory"
                                    :day-date="weekTitles[3]"
                                    :balance="balance"
                                    :isUserSubsidized="isSubsidized"
                                    :subsidizedPercentage="getSubsidizationPercentage(menuCategory)"
                                    :isHoliday="isHoliday(weekTitles[3])"
                                ></ordered-items-component>
                                <ordered-items-component
                                    @updateOrderItem=updateOrderItem($event,4)
                                    @showMenuItemDescription="setMenuItemDescription"
                                    :day-items="weeklyList[4]"
                                    :menu-category="menuCategory"
                                    :day-date="weekTitles[4]"
                                    :balance="balance"
                                    :isUserSubsidized="isSubsidized"
                                    :subsidizedPercentage="getSubsidizationPercentage(menuCategory)"
                                    :isHoliday="isHoliday(weekTitles[4])"
                                ></ordered-items-component>
                            </tr>
                            </tbody>
                        </table>
                    </b-col>
                </b-row>
                <p class="text-left p-1 m-0 color-grey">* klicken Sie auf den Kategorienamen, um die automatische
                    Bestellung zu aktivieren</p>
                <hr>
                <div>
                    <b-row>
                        <div id="menu-item-description">
                            <div v-if="selectedMenuItem !== null" class="w-100 text-left p-3">
                                <strong>{{ selectedMenuItem.name }}</strong>
                                <p class="white-space-pre-line">
                                    {{ selectedMenuItem.description }}
                                </p>
                            </div>
                        </div>
                    </b-row>
                    <hr v-if="selectedMenuItem !== null">
                    <b-row>
                        <div v-if="chosenDate === null" class="legend w-100 text-left p-3">
                            <p>
                                <strong>Legende der Zusatzstoffe:</strong> 1 - mit Farbstoff, 2 - mit
                                Konservierungsstoff, 3 - mit
                                Antioxidationsmittel, 4 - mit Geschmacksverstärker, 5 - mit Süßungsmittel, 6 - mit
                                Phosphat,
                                7 - gewachst, 8 - geschwärzt , 9 - geschwefelt, 14 - mit einer Phenylalaninquelle
                            </p>

                            <p>
                                <strong>Legende der Allergene:</strong> A - enth. Gluten, A1 - enth. Weizen, A2 - enth.
                                Roggen, A3 - enth.
                                Gerste, A4 - enth. Hafer, B - enth. Krebstiere, C - enth. Ei, D - enth. Fisch, E - enth.
                                Erdnüsse, F - enth. Soja (gen-tech-frei), G - enth. Milch einschl. Laktose, H - enth.
                                Schalenfrüchte, H1 - enth. Mandeln, H2 - enth. Haselnuss, H3 - enth. Walnuss, H4 - enth.
                                Kaschu(Cashew)nuss, H5 - enth. Pekannuss, H6 - enth. Paranuss, H7 - enth. Pistazie, H8 -
                                enth. Macadamianuss/Queenslandnuss, I - enth. Sellerie, J - enth. Senf , K - enth.
                                Sesam, L
                                - enth. Schwefeldioxid/Sulfite, M - enth. Lupinen, N - enth. Weichtiere
                            </p>

                            <p>
                                <strong>
                                    Aufgrund der Vielzahl der in unserer Küche verwendeten Lebensmittel können in all
                                    unseren Speisen Spuren der 14 Hauptallergene enthalten sein!
                                    Alle Angaben ohne Gewähr.
                                </strong>
                            </p>
                        </div>
                    </b-row>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    getMenuItems,
    storeFoodOrder,
    updateFoodOrder,
    removeFoodOrder,
    getMenuCategories,
    toggleAutoorderStatus,
    getConsumerInformation
} from "../../../api/foodOrder";

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
    computed:   {
        firstWeekDay: function () {
            return moment(this.weekTitles[0]).format('D MMMM');
        },
        lastWeekDay:  function () {
            return moment(this.weekTitles[4]).format('D MMMM');
        },
    },
    data:       () => ({
        isLoading:          true,
        chosenDate:         null,
        selectedMenuItem:   null,
        toastMessage:       '',
        isAutoordering:     false,
        weekTitles:         {
            0: null,
            1: null,
            2: null,
            3: null,
            4: null,
        },
        weeklyList:         {
            0: [],
            1: [],
            2: [],
            3: [],
            4: [],
        },
        moment:             null,
        menuCategories:     [],
        isSubsidized:       false,
        balance:            0,
        subsidizationRules: {},
        vacations:          []
    }),
    methods:    {
        /**
         * Generate previous week view
         */
        getPreviousWeek: async function () {
            const self            = this;
            this.isLoading        = true;
            this.chosenDate       = null;
            this.selectedMenuItem = null;
            let _currentWeek      = new Date(self.weekTitles[0]);
            _currentWeek.setDate(_currentWeek.getDate() - 7);
            _currentWeek.setHours(0, 0, 0, 0);
            await self.generateTitles(self.getFirstDay(_currentWeek));
            await self.generateList();
            await this._loadMenuCategories();
            await this._loadMenuItems(this.weekTitles[0], this.weekTitles[4]);
            self.isLoading = false;
        },
        /**
         * Generate next week view
         */
        getNextWeek: async function () {
            const self            = this;
            this.isLoading        = true;
            this.chosenDate       = null;
            this.selectedMenuItem = null;
            let _currentWeek      = new Date(self.weekTitles[0]);
            _currentWeek.setDate(_currentWeek.getDate() + 7);
            _currentWeek.setHours(0, 0, 0, 0);
            await self.generateTitles(self.getFirstDay(_currentWeek));
            await self.generateList();
            await this._loadMenuCategories();
            await this._loadMenuItems(this.weekTitles[0], this.weekTitles[4]);
            self.isLoading = false;
        },
        /**
         * Generate day title
         *
         * @param dayIndex
         * @returns {*}
         */
        getDayTitle: function (dayIndex) {
            const self = this;
            let _date  = new Date(self.weekTitles[dayIndex]);
            return moment(_date).format('ddd DD');
        },
        /**
         * Returns percentage for the particular menu category
         *
         * @param menuCategory
         * @returns Number
         */
        getSubsidizationPercentage: function (menuCategory) {
            // skip if subsidization rules are empty
            if (Object.keys(this.subsidizationRules).length === 0 && this.subsidizationRules.constructor ===
                Object) return 0;

            let subsidizationRule = this.subsidizationRules.filter(obj => {
                return obj.menu_category_id === menuCategory.id
            });

            return (typeof subsidizationRule !== "undefined" && (0 in subsidizationRule)) ?
                parseFloat(subsidizationRule[0]['percent']) : 0
        },
        /**
         * Generates an empty week list
         *
         * @returns {Promise<any>}
         */
        generateList() {
            const self = this;
            return new Promise(function (resolve, reject) {
                Object.getOwnPropertyNames(self.weekTitles).forEach(key => {
                    self.weeklyList[key] = [];
                });
                resolve();
            });

        },
        /**
         * Returns the first day of current week
         */
        getFirstDay: function (d) {
            d        = new Date(d);
            let day  = d.getDay(),
                diff = d.getDate() - day + (day == 0 ? -6 : 1); // adjust when day is sunday
            return new Date(d.setDate(diff));
        },
        /**
         * Add days quantity (increment) to retrieved date
         * @param firstDayDate
         * @param increment
         * @returns {Date}
         */
        addDays: function (firstDayDate, increment) {
            let date = new Date(firstDayDate.valueOf());
            date.setDate(date.getDate() + parseInt(increment));
            date.setHours(0, 0, 0, 0);
            return date;
        },
        /**
         * Generate week days titles
         *
         * @param firstDayDate
         * @returns {Promise<any>}
         */
        generateTitles:         function (firstDayDate) {
            const self = this;

            return new Promise(function (resolve, reject) {
                Object.getOwnPropertyNames(self.weekTitles).forEach(key => {
                    const _newDay        = self.addDays(firstDayDate, key);
                    self.weekTitles[key] = moment(_newDay).format('YYYY-MM-DD');
                });
                resolve();
            });
        },
        setMenuItemDescription: function (menuItem) {
            this.selectedMenuItem = menuItem;
            document.getElementById("menu-item-description")
                .scrollIntoView({behavior: 'smooth', block: 'start'});
        },
        /**
         * Update auto-ordering status for the current consumer
         *
         * @return void
         */
        updateAutoOrderStatus: async function () {
            this.isLoading = true;
            try {
                let response = await toggleAutoorderStatus();

                if (!response.data.success) {
                    this.isLoading = false;
                    this._showToastError('Internal error');
                    return;
                }
            } catch (e) {
                this._showToastError(e.toString());
                this.isLoading = false;
                return;
            }

            this.isAutoordering = !this.isAutoordering;
            this.isLoading      = false;
        },
        /**
         * Update autoordering status for the category and update ordered items
         *
         * @param categoryItem
         * @return void
         */
        updateAutoOrderStatusOld: async function (categoryItem) {
            // TODO: remove this functionality is auto-ordering functionality
            //  is approved and deployed on to the prod
            return;
            this.isLoading = true;

            let response = await setConsumerAutoOrderingStatus({
                'menu_category_id': categoryItem.id,
                'is_active':        categoryItem.is_ordered
            });
            if (!response.data.success) {
                this._showToastError('Internal error');
                return;
            }
            // TODO: this code order an item of each menu-item for the current week
            // update ordered items
            // let menuItemsForUpdate = [];
            // for (const [key, dayArray] of Object.entries(this.weeklyList)) {
            //     for (let i = 0; i < dayArray.length; i++) {
            //         let menuItem = dayArray[i];
            //         if (menuItem.menu_category_id != categoryItem.id
            //             || !isPermitToAddItem(menuItem.availability_date)) continue;
            //
            //         let updatedMenuItem      = {...menuItem};
            //         updatedMenuItem.quantity = categoryItem.is_ordered ? 1 : 0;
            //         menuItemsForUpdate.push(updatedMenuItem);
            //     }
            // }
            //
            // response = await storeFoodOrderItems({'items': menuItemsForUpdate});
            //
            // if (response.data.success) {
            //     // updated balance value
            //     this.balance                                       = parseFloat(response.data.balance);
            //     document.getElementById('balance-value').innerHTML = response.data.balance;
            // } else {
            //     this._showToastError('Internal error');
            //     return;
            // }

            /// reload menu items
            // await this._loadMenuItems(this.weekTitles[0], this.weekTitles[4]);
            let menuCategoryIndex = this.menuCategories.findIndex(x => x.id == categoryItem.id);
            this.$set(this.menuCategories, menuCategoryIndex, categoryItem);
            if (categoryItem.is_ordered) {
                const h         = this.$createElement;
                const vNodesMsg = h(
                    'p',
                    [
                        'Vielen Dank für Ihre Vorbestellung! Ihr Guthaben wird jeden Freitag um den entsprechenden Betrag reduziert.',
                        ' ',
                        h('a', {
                                attrs: {
                                    href:  '/uploads/files/ENTWURF%20AGBs%20MyFoodOrder%20V-1.0.pdf',
                                    class: 'brand-color'
                                }
                            },
                            'AGB'),
                        ' ',
                        h('a', {
                            attrs: {
                                href:  'https://lehmanns-gastronomie.de/datenschutzerklaerung/',
                                class: 'brand-color'
                            }
                        }, 'Datenschutz'),
                    ]
                );
                this._showToastSuccess(vNodesMsg);
            }

            this.isLoading = false;
        },
        /**
         * Update order item
         *
         * @param updatedItem
         * @param selectedDayIndex
         * @return void
         */
        updateOrderItem:          async function (updatedItem, selectedDayIndex) {
            this.isLoading        = true;
            let selectedItemIndex = this.weeklyList[selectedDayIndex]
                .findIndex(item => item.id === updatedItem.id);
            let response;
            try {
                if (updatedItem.quantity === 0) {
                    response = await removeFoodOrder({'data': updatedItem});
                } else if (updatedItem.quantity === 1 && updatedItem.foodorder_id == null) {
                    response = await storeFoodOrder({'data': updatedItem});
                } else {
                    response = await updateFoodOrder({'data': updatedItem});
                }

                if (response.data) {
                    let isAddItem = this.weeklyList[selectedDayIndex][selectedItemIndex].quantity < updatedItem.quantity;

                    // update handled item
                    updatedItem.foodorder_id = response.data.order ? response.data.order.id : null;
                    this.$set(this.weeklyList[selectedDayIndex], selectedItemIndex, updatedItem);
                    // updated balance value
                    this.balance                                       = parseFloat(response.data.balance);
                    document.getElementById('balance-value').innerHTML = response.data.balance;

                    if (isAddItem) {
                        this._showItemOrderedMessage();
                    } else {
                        this._showItemCanceledMessage();
                    }
                } else {
                    let message = '';

                    Object.values(response.data.errors).forEach(function (messagesArray, key) {
                        message += messagesArray[0] + "\r\n";
                    });
                    this._showToastWarning(message);
                }

            } catch (e) {
                this._showToastError(e.toString());
            }

            this.isLoading = false;
        },
        _showItemOrderedMessage:  function () {
            const h       = this.$createElement;
            let vNodesMsg = h(
                'p',
                [
                    'Bestellung erfolgt\n' +
                    'Vielen Dank für Ihre Essensbestellung. Ihr Guthaben wurde um den entsprechenden Betrag reduziert.',
                    ' ',
                    h('a', {
                        attrs: {
                            href:  '/uploads/files/ENTWURF%20AGBs%20MyFoodOrder%20V-1.0.pdf',
                            class: 'brand-color'
                        }
                    }, 'AGB'),
                    ' ',
                    h('a', {
                        attrs: {
                            href:  'https://lehmanns-gastronomie.de/datenschutzerklaerung/',
                            class: 'brand-color'
                        }
                    }, 'Datenschutz'),
                ]
            );

            this._showToastSuccess(vNodesMsg, 'Bestellung erfolgt');
        },
        _showItemCanceledMessage: function () {
            const h = this.$createElement;

            let vNodesMsg = h(
                'p',
                [
                    'Bestellung storniert\n' +
                    'Sie haben Ihre Bestellung storniert. Ihr Guthaben wurde um den entsprechenden Betrag erhöht.',
                    ' ',
                    h('a', {
                        attrs: {
                            href:  '/uploads/files/ENTWURF%20AGBs%20MyFoodOrder%20V-1.0.pdf',
                            class: 'brand-color'
                        }
                    }, 'AGB'),
                    ' ',
                    h('a', {
                        attrs: {
                            href:  'https://lehmanns-gastronomie.de/datenschutzerklaerung/',
                            class: 'brand-color'
                        }
                    }, 'Datenschutz'),
                ]
            );

            this._showToastError(vNodesMsg, 'Bestellung storniert');
        },
        _loadMenuItems:           async function (startDate, endDate) {
            const self = this;
            try {
                let response   = await getMenuItems({"start_date": startDate, "end_date": endDate});
                self.vacations = response['data']['vacations'];
                let menuItems  = response['data']['menuItems'];
                Object.getOwnPropertyNames(self.weekTitles).forEach(key => {
                    self.weeklyList[key] = [];
                    menuItems.forEach(function (menuItem) {
                        if (menuItem['availability_date'] == self.weekTitles[key]) {
                            if (menuItem['users_food_orders'] !== null) {
                                menuItem['quantity']     = parseInt(menuItem['users_food_orders']['quantity']);
                                menuItem['foodorder_id'] = menuItem['users_food_orders']['id'];
                            } else {
                                menuItem['quantity'] = 0;
                            }

                            menuItem['is_subsidized'] =
                                self.menuCategories.find(menuCategory => menuCategory.id == menuItem['menu_category_id'])['is_allow_for_subsidization'];

                            self.weeklyList[key].push(menuItem);
                        }
                    });
                });

            } catch (e) {
                this._showToastError(e.toString());
            }
        },
        _loadMenuCategories:      async function () {
            try {
                let response = await getMenuCategories();

                this.menuCategories = Object.values(response['data']['data']);
                this.menuCategories
                    .sort(function (a, b) {
                        return a.category_order - b.category_order;
                    });

            } catch (e) {
                this._showToastError(e.toString());
            }
        },
        _loadConsumerInfo:        async function () {
            try {
                let response            = await getConsumerInformation();
                this.isSubsidized       = response['data']['is_subsidized'];
                this.isAutoordering     = response['data']['is_auto_ordering'];
                this.balance            = parseFloat(response['data']['balance']);
                this.subsidizationRules = typeof response['data']['subsidization_rules'] === "undefined"
                    ? {}
                    : response['data']['subsidization_rules'];
            } catch (e) {
                this._showToastError(e.toString());
            }
        },
        // TODO: move toast functionality to another component
        _showToastSuccess(message = '', title = 'Erfolg') {
            this.$bvToast.toast(message, {
                toaster:       'b-toaster-bottom-left',
                title:         title,
                variant:       'success',
                autoHideDelay: 3000,
            });
        },
        _showToastWarning(message = '', title = 'Etwas stimmt nicht') {
            this.$bvToast.toast(message, {
                toaster:       'b-toaster-bottom-left',
                title:         title,
                variant:       'warning',
                autoHideDelay: 3000,
            });
        },
        _showToastError(message = '', title = 'Error') {
            this.$bvToast.toast(message, {
                toaster:       'b-toaster-bottom-left',
                title:         title,
                variant:       'danger',
                autoHideDelay: 3000,
            });
        },
        isHoliday(date) {
            const self    = this;
            let isHoliday = false;

            if (self.vacations.length === 0) return isHoliday;

            this.vacations.forEach(function (vacation) {
                const startDate   = moment(vacation.start_date).format('YYYY-MM-DD');
                const endDate     = moment(vacation.end_date).format('YYYY-MM-DD');
                const currentDate = moment(date).format('YYYY-MM-DD');

                if (startDate <= currentDate && endDate >= currentDate) {
                    isHoliday = true;
                }
            })

            return isHoliday;
        },
    },
    created() {
        moment.locale('de');
    },
    async mounted() {
        let _today = new Date();
        _today.setHours(0, 0, 0, 0);
        await this.generateTitles(this.getFirstDay(_today));
        await this.generateList();
        await this._loadMenuCategories();
        await this._loadConsumerInfo();
        await this._loadMenuItems(this.weekTitles[0], this.weekTitles[4]);
        this.isLoading = false;
    },
}
</script>

<style lang="scss">
@import './node_modules/bootstrap/scss/bootstrap.scss';
@import './node_modules/bootstrap-vue/src/index.scss';

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

.menu-item-card {
    cursor: pointer;
}

.menu-item-card.forbid {
    cursor: not-allowed;
}

.menu-item-card .price {
    white-space: nowrap;
    color: #EB9B00;
}

.menu-item-card:hover {
    -webkit-box-shadow: 2px 2px 5px 0px rgba(135, 135, 135, 1);
    -moz-box-shadow: 2px 2px 5px 0px rgba(135, 135, 135, 1);
    box-shadow: 2px 2px 5px 0px rgba(135, 135, 135, 1);
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

>>> td.auto-ordered {
    background: #5cb48e47;
}

.color-grey {
    color: #999999;
}

.fs-12 {
    font-size: 12px;
}

.legend * {
    font-size: 12px;
}

.white-space-pre-line {
    white-space: pre-line;
}

/**
 * Button styles
 */
.btn-outline-brand, .btn-outline-brand:hover {
    color: #96c11f;
    border-color: #96c11f;
    background-color: #ffffff;
}

.btn-brand,
.btn-brand:hover {
    background-color: #96c11f;
    border-color: #96c11f;
    color: #ffffff;
}

.btn-brand:focus,
.btn-brand:hover,
.btn-brand:active,
.btn-outline-brand:focus,
.btn-outline-brand:hover,
.btn-outline-brand:active {
    box-shadow: 0 0 0 0.2rem rgba(150, 193, 31, 0.5);
}

.week-control-button:hover,
.week-control-button:active {
    color: #ffffff;
}

.week-control-button:focus {
    color: #96c11f;
}
</style>
