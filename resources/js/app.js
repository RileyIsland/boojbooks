import Index from "./components/index";
import BookList from "./components/BookList";
import Vue from "vue";
import {BootstrapVue, IconsPlugin} from "bootstrap-vue";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.component('index', Index);

const vm = new Vue({
    el: '#app',
    data: {
        bookListId: bookListId
    },
    render(createElement) {
        return createElement(Index,
            {
                props: {
                    bookListId: bookListId
                }
            },
            BookList
        );
    }
})
