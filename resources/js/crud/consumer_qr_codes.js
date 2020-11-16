import initGridPage from "./consumer_qr_codes/pages";
import initViePage  from "./consumer_qr_codes/pages/view";
import initFormPage from "./consumer_qr_codes/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
