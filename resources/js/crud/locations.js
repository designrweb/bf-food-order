import initGridPage from "./locations/pages";
import initViePage  from "./locations/pages/view";
import initFormPage from "./locations/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
