window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import QrCodeComponent                    from '../components/QrCodeComponent';

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

function init() {
    let $page = document.querySelector('#qr-code-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#qr-code-page',
        components: {
            "qr-code-page": QrCodeComponent
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
