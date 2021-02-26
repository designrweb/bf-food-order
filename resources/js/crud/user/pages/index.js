window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import IndexComponent                    from '../componennts/IndexComponent';

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

function init() {
    let $page = document.querySelector('#grid-index-page');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#grid-index-page',
        components: {
            "grid-index": IndexComponent
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
