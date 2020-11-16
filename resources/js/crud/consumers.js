import initGridPage from "./consumers/pages";
import initViePage  from "./consumers/pages/view";
import initFormPage from "./consumers/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
