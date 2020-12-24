window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import MealOrdersComponent               from '../components/MealOrdersComponent';

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

function init() {
    let $page = document.querySelector('#meal-orders-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#meal-orders-page',
        components: {
            "meal-orders": MealOrdersComponent
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
