/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Swal = require('sweetalert2');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import BootstrapVue from "bootstrap-vue";
import { ValidationProvider, extend, ValidationObserver } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import es from 'vee-validate/dist/locale/es';
import VueCurrencyFilter from 'vue-currency-filter';
import Swatches from 'vue-swatches';
import 'vue-swatches/dist/vue-swatches.min.css';
import tinymce from 'vue-tinymce-editor';
import VueCarousel from 'vue-carousel';
import vueRut from 'vue-rut'

// Register it globally

for (let rule in rules) {
    extend(rule, {
      ...rules[rule],
      message: es.messages[rule]
    });
}

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('Swatches', Swatches);
Vue.component('tinymce', tinymce);

Vue.use(BootstrapVue);
Vue.use(VueCarousel);
Vue.use(vueRut);
Vue.use(VueCurrencyFilter,
{
    symbol : '$',
    thousandsSeparator: '.',
    fractionCount: 0,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
});

Vue.component('general', require('./components/General.vue').default);
Vue.component('sliders', require('./components/Sliders.vue').default);
Vue.component('nosotros', require('./components/Nosotros.vue').default);
Vue.component('comunidad', require('./components/Comunidad.vue').default);
Vue.component('servicios', require('./components/Servicios.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('sliders-home', require('./components/SlidersHome.vue').default);
Vue.component('categoria-documentos', require('./components/CategoriaDocumentos.vue').default);
Vue.component('documentos', require('./components/Documentos.vue').default);
Vue.component('categorias-usuario', require('./components/CategoriasUsuario.vue').default);
Vue.component('slider-footer', require('./components/SliderFooter.vue').default);
Vue.component('categorias-home', require('./components/MostrarCategorias.vue').default);
Vue.component('sliders-ubicacion', require('./components/SlidersUbicacion.vue').default);
Vue.component('documentos-tipo', require('./components/DocumentosHome.vue').default);
Vue.component('tips', require('./components/Tips.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);
Vue.component('usuarios-black-list', require('./components/UsuariosListaNegra.vue').default);
Vue.component('sorteos', require('./components/Sorteos.vue').default);
Vue.component('promociones', require('./components/Promociones.vue').default);
Vue.component('solicitar-documento', require('./components/SolicitarDocumento.vue').default);
Vue.component('recomendar', require('./components/Recomendar.vue').default);
Vue.component('solicitar-asesoria', require('./components/SolicitarAsesoria.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data :{
        ubicacion: 1,
        menu : 3
    }
});