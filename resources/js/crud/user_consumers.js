import initGridPage from "./user/consumers/pages/form";
import initIndexPage from "./user/consumers/pages/index";
import initViewPage from "./user/consumers/pages/view";

function init() {
    initGridPage();
    initIndexPage();
    initViewPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
