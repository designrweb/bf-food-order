import initGridPage from "./catering_items/pages";
import initViePage  from "./catering_items/pages/view";
import initFormPage from "./catering_items/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
