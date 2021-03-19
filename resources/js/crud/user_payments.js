import initGridPage       from "./user/payments/pages";
import initViePage        from "./user/payments/pages/view";
import initFormPage       from "./user/payments/pages/form";
import initMealOrdersPage from "./user/payments/pages/mealOrders";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
    initMealOrdersPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
