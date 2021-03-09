import initGridPage   from "./user/consumers/pages/form";
import initIndexPage  from "./user/consumers/pages/index";
import initViewPage   from "./user/consumers/pages/view";
import initQrCodePage from "./user/consumers/pages/qr-code";

function init() {
    initGridPage();
    initIndexPage();
    initViewPage();
    initQrCodePage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
