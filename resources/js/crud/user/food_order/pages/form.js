import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import IndexComponent                    from '../components/Form';

window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
import { ToastPlugin } from 'bootstrap-vue'
Vue.use(ToastPlugin)

function init() {
    let $page = document.querySelector('#grid-form-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#grid-form-page',
        components: {
            "grid-form": IndexComponent
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
