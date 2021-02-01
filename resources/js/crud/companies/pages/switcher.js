window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import CompaniesSwitcherComponent                    from '../components/CompaniesSwitcherComponent';

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

function init() {
    let $page = document.querySelector('#companies-switcher-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#companies-switcher-page',
        components: {
            "companies-switcher": CompaniesSwitcherComponent
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
