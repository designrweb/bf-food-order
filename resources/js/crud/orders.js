import initGridPage from "./orders/pages";
import initViePage  from "./orders/pages/view";
import initFormPage from "./orders/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
