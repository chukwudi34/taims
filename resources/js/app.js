import Vue from "vue";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
// Import Bootstrap and BootstrapVue CSS files (order is important)
// import 'bootstrap/dist/css/bootstrap.css'
import "bootstrap-vue/dist/bootstrap-vue.css";
import { InertiaProgress } from "@inertiajs/progress";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueToast from "vue-toast-notification";
import VueSweetalert2 from "vue-sweetalert2";
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import "vue-toast-notification/dist/theme-sugar.css";

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
Vue.component("pagination", require("laravel-vue-pagination"));
Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
import VueMask from "v-mask";
Vue.use(VueMask);

Vue.use(VueToast, {
    // One of the options
    position: "top",
    duration: 3000,
});

Vue.component("inertia-link", Link);

window.eventBus = new Vue();

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: "#fbc2eb", //'#29d',

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: true,
});

Vue.prototype.$route = route;

createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin);

        new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
});
