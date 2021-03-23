import initGridPage       from "./user/payments/pages";
import initMealOrdersPage from "./user/payments/pages/mealOrders";

function init() {
    initGridPage();
    initMealOrdersPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
