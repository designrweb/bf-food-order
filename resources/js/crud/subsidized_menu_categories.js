import initGridPage from "./subsidized_menu_categories/pages";
import initViePage  from "./subsidized_menu_categories/pages/view";
import initFormPage from "./subsidized_menu_categories/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
