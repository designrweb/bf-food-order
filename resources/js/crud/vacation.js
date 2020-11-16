import initGridPage from "./vacation/pages";
import initViePage  from "./vacation/pages/view";
import initFormPage from "./vacation/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
