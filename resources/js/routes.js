window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)


export default new VueRouter({
    routes: [
        {
            path: '/',
            name: 'login'
            //component: Login
        }
    ],
    mode: 'history'
})
