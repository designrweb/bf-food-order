import initGridPage from "./catering_categories/pages";
import initViePage  from "./catering_categories/pages/view";
import initFormPage from "./catering_categories/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
