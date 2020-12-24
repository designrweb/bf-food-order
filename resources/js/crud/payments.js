import initGridPage       from "./payments/pages";
import initViePage        from "./payments/pages/view";
import initFormPage       from "./payments/pages/form";
import initMealOrdersPage from "./payments/pages/mealOrders";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
    initMealOrdersPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
