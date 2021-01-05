import ViewComponent                     from "../components/ViewComponent";

window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

function init() {
    let $page = document.querySelector('#grid-view-page');

    if (typeof($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:    '#grid-view-page',
        components: {
            "grid-view": ViewComponent
        },
        props: {
            main_route: String
        }
    });
}

export default init;
