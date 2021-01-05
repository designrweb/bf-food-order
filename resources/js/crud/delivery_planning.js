import initGridPage from "./delivery_planning/pages";
import initViePage  from "./delivery_planning/pages/view";
import initFormPage from "./delivery_planning/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
