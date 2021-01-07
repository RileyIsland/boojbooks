import Vue from "vue";
import {BootstrapVue, IconsPlugin} from "bootstrap-vue";
import VueCookies from "vue-cookies";
import VueRouter from "vue-router";
import routes from "./routes";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueCookies);
Vue.use(VueRouter);

const vm = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
