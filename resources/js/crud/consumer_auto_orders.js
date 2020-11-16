import initGridPage from "./consumer_auto_orders/pages";
import initViePage  from "./consumer_auto_orders/pages/view";
import initFormPage from "./consumer_auto_orders/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
