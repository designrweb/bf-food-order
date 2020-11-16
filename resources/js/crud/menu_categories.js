import initGridPage from "./menu_categories/pages";
import initViePage  from "./menu_categories/pages/view";
import initFormPage from "./menu_categories/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
