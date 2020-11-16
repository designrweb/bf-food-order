import initGridPage from "./voucher_limits/pages";
import initViePage  from "./voucher_limits/pages/view";
import initFormPage from "./voucher_limits/pages/form";

function init() {
    initGridPage();
    initViePage();
    initFormPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
