import CombinedFormComponent             from "../components/CombinedFormComponent";
import Croppa                            from 'vue-croppa';

import 'vue-croppa/dist/vue-croppa.css';

window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(Croppa);

function init() {
    let $page = document.querySelector('#grid-combined-form-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#grid-combined-form-page',
        components: {
            "grid-combined-form": CombinedFormComponent
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
