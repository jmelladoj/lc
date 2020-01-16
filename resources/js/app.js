/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Swal = require('sweetalert2');
window.Event = new Vue ();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import BootstrapVue from 'bootstrap-vue'
import { ValidationProvider, extend, ValidationObserver } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import es from 'vee-validate/dist/locale/es';
import VueCurrencyFilter from 'vue-currency-filter';
import Swatches from 'vue-swatches';
import 'vue-swatches/dist/vue-swatches.min.css';
import tinymce from 'vue-tinymce-editor';
import VueCarousel from 'vue-carousel';
import { rutInputDirective } from 'vue-dni';
import VueRouter from 'vue-router';
import router from './routes.js';
import VueToast from 'vue-toast-notification';
import SpellChecker from 'tinymce/plugins/spellchecker';


import 'vue-toast-notification/dist/index.css';

Vue.directive('rut', rutInputDirective);
Vue.use(VueToast);

Vue.use(VueCurrencyFilter,{
    symbol : '$',
    thousandsSeparator: '.',
    fractionCount: 0,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
})

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



Vue.use(VueRouter);
Vue.use(VueCarousel);
Vue.use(VueCurrencyFilter,
{
    symbol : '$',
    thousandsSeparator: '.',
    fractionCount: 0,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
});

Vue.use(BootstrapVue)

//General
Vue.component('sociales', require('./components/general/Sociales.vue').default);
Vue.component('perfil_usuario', require('./components/general/Perfil.vue').default);
Vue.component('ver-documento', require('./components/general/VerDocumento.vue').default);
Vue.component('errores', require('./components/general/Errores.vue').default);

//Pagina
Vue.component('login', require('./components/pagina/Login.vue').default);
Vue.component('sliders-home', require('./components/pagina/SlidersHome.vue').default);
Vue.component('slider-footer', require('./components/pagina/SliderFooter.vue').default);
Vue.component('categorias-home', require('./components/pagina/MostrarCategorias.vue').default);
Vue.component('sliders-ubicacion', require('./components/pagina/SlidersUbicacion.vue').default);
Vue.component('documentos-tipo', require('./components/pagina/DocumentosHome.vue').default);
Vue.component('nosotros', require('./components/pagina/Nosotros.vue').default);
Vue.component('top-five', require('./components/pagina/TopFive.vue').default);
Vue.component('sliders-comunidad-pyme', require('./components/pagina/SlidersComunidadPyme.vue').default);
Vue.component('busqueda', require('./components/pagina/Busqueda.vue').default);
Vue.component('iniciar-sesion', require('./components/pagina/IniciarSesion.vue').default);
Vue.component('contacto', require('./components/pagina/Contacto.vue').default);
Vue.component('politicas', require('./components/pagina/Politicas.vue').default);

//Intranet
Vue.component('general', require('./components/intranet/General.vue').default);
Vue.component('sliders', require('./components/intranet/Sliders.vue').default);
Vue.component('sliders-comunidad', require('./components/intranet/SlidersComunidad.vue').default);
Vue.component('comunidad', require('./components/intranet/Comunidad.vue').default);
Vue.component('servicios', require('./components/intranet/Servicios.vue').default);
Vue.component('categoria-documentos', require('./components/intranet/CategoriaDocumentos.vue').default);
Vue.component('categorias-usuario', require('./components/intranet/CategoriasUsuario.vue').default);
Vue.component('tips', require('./components/intranet/Tips.vue').default);
Vue.component('usuarios', require('./components/intranet/Usuarios.vue').default);
Vue.component('usuarios-black-list', require('./components/intranet/UsuariosListaNegra.vue').default);
Vue.component('sorteos', require('./components/intranet/Sorteos.vue').default);
Vue.component('promociones', require('./components/intranet/Promociones.vue').default);
Vue.component('solicitar-documento', require('./components/intranet/SolicitarDocumento.vue').default);
Vue.component('recomendar', require('./components/intranet/Recomendar.vue').default);
Vue.component('solicitar-asesoria', require('./components/intranet/SolicitarAsesoria.vue').default);
Vue.component('rubros', require('./components/intranet/Rubros.vue').default);
Vue.component('documentos', require('./components/intranet/Documentos.vue').default);
Vue.component('profesiones', require('./components/intranet/Profesiones.vue').default);
Vue.component('profesiones-rubros', require('./components/intranet/ProfesionesRubros.vue').default);
Vue.component('perfil', require('./components/intranet/Perfil.vue').default);
Vue.component('solicitud-documentos', require('./components/intranet/SolicitudDocumentos.vue').default);
Vue.component('notificaciones', require('./components/intranet/Notificaciones.vue').default);
Vue.component('asesorias', require('./components/intranet/Asesorias.vue').default);
Vue.component('seminarios', require('./components/intranet/Seminarios.vue').default);
Vue.component('interes', require('./components/intranet/Interes.vue').default);
Vue.component('alertas', require('./components/intranet/Alertas.vue').default);
Vue.component('recargas', require('./components/intranet/Recargar.vue').default);
Vue.component('tabla-vip', require('./components/intranet/TablaVip.vue').default);





/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var EventBus = new Vue;

const app = new Vue({
    el: '#app',
    data :{
        ubicacion: 1,
        menu : 1
    },
    router
});
