require('./bootstrap');
import {
    BootstrapVue,
    IconsPlugin
} from 'bootstrap-vue'
import {
    BIconArrowUpRightSquare,
    BIconSave
} from 'bootstrap-vue'
// arrow-up-right-square
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import JwPagination from 'jw-vue-pagination';
import VueRouter from 'vue-router'
import VueEllipseProgress from 'vue-ellipse-progress'
import Toast, {
    POSITION
} from "vue-toastification"
import "vue-toastification/dist/index.css";
import App from './layouts/App.vue';
import {
    routes
} from './routes'
import VueSidebarMenu from 'vue-sidebar-menu'

window.Vue = require('vue').default;
Vue.use(IconsPlugin)
Vue.use(BootstrapVue)
Vue.use(VueRouter)
Vue.use(VueSidebarMenu)


Vue.use(VueEllipseProgress)
Vue.use(Toast, {
    position: POSITION.BOTTOM_LEFT,

});
Vue.component('jw-pagination', JwPagination)
Vue.component('BIconArrowUpRightSquare', BIconArrowUpRightSquare)


const router = new VueRouter({
    mode: 'history',
    routes,

})

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
