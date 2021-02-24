import FormComponent                     from "../componennts/FormComponent";
import Croppa                            from "vue-croppa";

window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(Croppa);

function init() {
    let $page = document.querySelector('#grid-form-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#grid-form-page',
        components: {
            "grid-form": FormComponent
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
