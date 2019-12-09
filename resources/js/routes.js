window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Sorteos from "./components/intranet/Sorteos.vue"

export default new VueRouter({
    routes: [
        {
            path: '/prueba',
            name: 'prueba',
            component: Sorteos
        }
    ],
    mode: 'history'
})
