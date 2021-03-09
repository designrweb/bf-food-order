import initGridPage from "./user/profile/pages/form.js";
import initIndexPage from "./user/profile/pages/index.js";

function init() {
    initGridPage();
    initIndexPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
