import initGridPage from "./administrators/pages";
import initViePage  from "./administrators/pages/view";
import initFormPage from "./administrators/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
