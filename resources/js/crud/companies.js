import initGridPage from "./companies/pages";
import initViePage  from "./companies/pages/view";
import initFormPage from "./companies/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
