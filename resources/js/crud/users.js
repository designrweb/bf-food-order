import initGridPage from "./users/pages";
import initViePage  from "./users/pages/view";
import initFormPage from "./users/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
