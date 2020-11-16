import initGridPage from "./consumer_subsidizations/pages";
import initViePage  from "./consumer_subsidizations/pages/view";
import initFormPage from "./consumer_subsidizations/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
