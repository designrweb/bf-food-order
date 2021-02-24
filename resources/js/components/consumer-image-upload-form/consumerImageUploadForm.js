import ConsumerImageUploadForm from "./components/ConsumerImageUploadForm";
import Croppa from 'vue-croppa';
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
window.Vue = require('vue');

Vue.use(Croppa)
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);


function init() {
    let $page = document.querySelector('#consumer-image-upload-form');

    if (typeof ($page) == 'undefined' || $page == null) return false;

    new Vue({
        el:         '#consumer-image-upload-form',
        components: {
            "consumer-image-upload-form": ConsumerImageUploadForm
        },
        props:      {
            main_route: String
        }
    });
}

export default init;
