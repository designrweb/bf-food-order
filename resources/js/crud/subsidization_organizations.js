import initGridPage from "./subsidization_organizations/pages";
import initViePage  from "./subsidization_organizations/pages/view";
import initFormPage from "./subsidization_organizations/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
