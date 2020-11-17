import initGridPage from "./subsidization_rules/pages";
import initViePage  from "./subsidization_rules/pages/view";
import initFormPage from "./subsidization_rules/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
