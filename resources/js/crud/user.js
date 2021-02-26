import initGridPage from "./user/pages/form.js";
import initIndexPage from "./user/pages/index.js";

function init() {
    initGridPage();
    initIndexPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
