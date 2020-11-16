import initGridPage from "./location_group/pages";
import initViePage  from "./location_group/pages/view";
import initFormPage from "./location_group/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
