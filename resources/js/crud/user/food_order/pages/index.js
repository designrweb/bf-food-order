import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import Orders                            from '../components/Orders';

window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

function init() {
    let $page = document.querySelector('#index-form-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#index-form-page',
        components: {
            "grid-index": Orders
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
