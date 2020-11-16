import initGridPage from "./vacation_location_group/pages";
import initViePage  from "./vacation_location_group/pages/view";
import initFormPage from "./vacation_location_group/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
