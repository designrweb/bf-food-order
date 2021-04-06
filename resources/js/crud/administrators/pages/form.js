import FormComponent                     from "../components/FormComponent";

window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

function init() {
    let $page = document.querySelector('#grid-form-page');

    if (typeof($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:    '#grid-form-page',
        components: {
            "grid-form": FormComponent
        },
        props: {
            main_route: String
        }
    });
}

export default init;
