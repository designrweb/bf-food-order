import initGridPage   from "./user/food_order/pages/form";
import initIndexPage   from "./user/food_order/pages/index";

function init() {
    initGridPage();
    initIndexPage();
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});
