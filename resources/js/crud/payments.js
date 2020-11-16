import initGridPage from "./payments/pages";
import initViePage  from "./payments/pages/view";
import initFormPage from "./payments/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
