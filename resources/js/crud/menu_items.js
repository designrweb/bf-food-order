import initGridPage from "./menu_items/pages";
import initViePage  from "./menu_items/pages/view";
import initFormPage from "./menu_items/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
