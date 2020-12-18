import initGridPage         from "./settings/pages";
import initViePage          from "./settings/pages/view";
import initFormPage         from "./settings/pages/form";
import initCombinedFormPage from "./settings/pages/combinedform";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
    initCombinedFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
