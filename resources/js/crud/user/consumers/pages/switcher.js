window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import ConsumerSwitcher                  from '../components/ConsumerSwitcher';

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

function init() {
    let $page = document.querySelector('#consumer-switcher-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#consumer-switcher-page',
        components: {
            "consumer-switcher": ConsumerSwitcher
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
