import initGridPage from "./settings/pages";
import initViePage  from "./settings/pages/view";
import initFormPage from "./settings/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
