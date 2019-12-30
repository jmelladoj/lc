<template>
    <section class="sec-padding-login mt-5 mb-5">
        <div class="container">
            <errores :errors="validationErrors" v-if="validationErrors"> </errores>
            <div class="row">
                <div class="offset-md-2 col-md-8" v-show="formulario == 0">
                    <div class="my-account-box mb-4" id="ingreso" name="ingreso">
                        <form class="form-full-height">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Inicia tu sesión</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="mt-0 btn btn--secondary space--1 btn-sm boton_login" @click="limpiar_login" v-show="estados.boton_login_inicia == 1">Limpiar</button>
                                    <button type="button" class="mt-0 btn btn--secondary space--1 boton_login" @click="formulario = 1" v-if="estados.boton_login_registrate == 1">... Regístrate</button>
                                </div>
                            </div>


                            <p class="large text-justify">Bienvenido a tu comunidad LebenCo.</p>
                            <p class="form-field-wrapper">
                                <input class="input--lg form-full" v-rut v-model="usuario_login.run" @keyup="mostrar_botones_login" autocomplete="run" type="text" placeholder="RUN personal o RUT si eres una Pyme" required>
                            </p>
                            <p class="form-field-wrapper">
                                <input class="input--lg form-full" v-model="usuario_login.password"  @keyup="mostrar_botones_login" autocomplete="current-password" type="password" @keyup.enter="ingresar" placeholder="Ingresa tu clave" required>
                            </p>
                            <p class="form-field-wrapper">
                                <label class="">
                                    <input class="" v-model="usuario_login.remember" type="checkbox">
                                    <span>Recuérdame</span>
                                </label>
                            </p>
                            <p class="form-field-wrapper form-row" v-if="estados.boton_login_inicia == 1">
                                <button type="button" class="btn btn--lg btn--secondary" name="login" value="Log in" @click="ingresar">Ingresar</button>
                            </p>
                            <p class="form-field-wrapper lost_password mb-5">
                                <b-button v-b-modal.recuperar_cuenta class="mt-0 btn btn--secondary space--1 btn-sm boton_login">Recuperar mi cuenta</b-button>
                            </p>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="my-account-box" id="registro" name="registro" v-show="formulario == 1">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Regístrate</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="mt-0 btn btn--secondary space--1 btn-sm boton_login" @click="limpiar_registro" v-show="estados.boton_registro_registrarse == 1">Limpiar</button>
                                    <button type="button" class="mt-0 btn btn--secondary space--1 btn-sm boton_login" @click="formulario = 0" v-if="estados.boton_registro_inicia == 1">... Inicia tu sesión</button>
                                </div>
                            </div>
                            <p class="large text-justify">Disponemos de herramientas para Pymes, Estudiantes del área, Personas y Personas encargadas de la prevención.</p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="estudiante" @change="mostrar_botones_registrate" name="tipo_persona" v-model="usuario_nuevo.tipo_persona" class="custom-control-input" value="3">
                                            <label class="custom-control-label" for="estudiante"> Estudiante</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="persona" @change="mostrar_botones_registrate" name="tipo_persona" v-model="usuario_nuevo.tipo_persona" class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="persona"> Persona</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="empresa" @change="mostrar_botones_registrate" name="tipo_persona" v-model="usuario_nuevo.tipo_persona" class="custom-control-input" value="2">
                                            <label class="custom-control-label" for="empresa"> Pyme</label>
                                        </div>
                                    </div>
                                </div>
                            </p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <input class="input--lg form-full" @keyup="mostrar_botones_registrate" v-model="usuario_nuevo.nombre" type="text" placeholder="Nombre completo o Razón social" required>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input class="input--lg form-full run_nuevo" @keyup="mostrar_botones_registrate" v-rut:live v-model="usuario_nuevo.run" type="text" placeholder="RUN personal o RUT si eres una Pyme" required>
                                        <span id="alerta_rut" class="d-none"><span class="d-block alert alert-danger m-t-5">Rut o run invalido</span></span>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input class="input--lg form-full" @keyup="mostrar_botones_registrate" v-model="usuario_nuevo.email" type="email" placeholder="Correo electrónico" required>
                                    </div>
                                </div>
                            </p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <input class="input--lg form-full" @keyup="mostrar_botones_registrate" v-model="usuario_nuevo.clave_uno" type="password" placeholder="Crea tu clave (6 caracteres)" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input class="input--lg form-full" @keyup="mostrar_botones_registrate" v-model="usuario_nuevo.clave_dos" type="password" placeholder="Repite esa clave" required>
                                    </div>
                                </div>
                            </p>
                            <p class="form-field-wrapper text-justify">
                                Sus datos personales se utilizarán con el fin de respaldar su experiencia en nuestro sitio web, administrar el acceso a su cuenta y para otros fines descritos en <a class="sale-color" href="/politicas" target="_blank">nuestras Políticas </a>, al registrarse usted acepta nuestros términos de uso y condiciones de privacidad, que han sido establecidas por Prevención LebenCo. SpA.
                            </p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="">
                                            <input class="" v-model="usuario_nuevo.mailing" type="checkbox">
                                            <span>Quiero recibir notificaciones importantes de la comunidad LebenCo.</span>
                                        </label>
                                    </div>
                                    <div class="col-md-6 text-right" v-if="estados.boton_registro_registrarse == 1">
                                        <button type="button" class="btn btn--lg btn--secondary" @click="registrar">Registrarme</button>
                                    </div>
                                </div>
                            </p>
                        </form>
                    </div>
                </div>

                <ValidationObserver ref="observer_servicio" v-slot="{ valid }">
                    <b-modal ref="recuperar_cuenta" id="recuperar_cuenta" title="Recuperar mi cuenta">
                        <b-form-group label="Ingresa el correo asociado a tu cuenta">
                            <ValidationProvider name="correo" rules="required|min:3|email" v-slot="{ errors }">
                                <b-form-input type="text" v-model="recuperar_cuenta.email"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <template slot="modal-footer">
                            <b-button size="md" variant="success" :disabled="!valid" @click="recuperar_password">Recuperar mi cuenta</b-button>
                            <b-button size="md" variant="danger" @click="cerrar_modal"> Cerrar </b-button>
                        </template>
                    </b-modal>
                </ValidationObserver>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                errors: [],
                formulario: 0,
                estados: {
                    boton_login_registrate: 0,
                    boton_login_inicia: 0,
                    boton_registro_inicia: 0,
                    boton_registro_registrarse: 0
                },
                usuario_login: {
                    run: '',
                    password: '',
                    remember: false
                },
                usuario_nuevo: {
                    tipo_persona: 0,
                    nombre: '',
                    run: '',
                    email: '',
                    clave_uno: '',
                    clave_dos: '',
                    mailing: false
                },
                recuperar_cuenta: {
                    email: ''
                },
                validationErrors: ''
            }
        },
        methods:{
            ingresar(){
                let me=this;
                axios.post('/login',{
                    'run': me.usuario_login.run,
                    'password': me.usuario_login.password,
                    'remember': me.usuario_login.remember,
                }).then(function (response) {
                    var redireccion = $('#redireccion').val()

                    if(redireccion){
                        window.location.href = "/intranet/" + redireccion
                    } else {
                        window.location.href = "/home";
                    }
                })
                .catch(function (error) {
                    if (error.response.status == 422){
                        me.validationErrors = error.response.data.errors;
                    }
                });
            },
            registrar(){
                let me=this;
                axios.post('/register',{
                    'tipo_persona': me.usuario_nuevo.tipo_persona,
                    'nombre': me.usuario_nuevo.nombre,
                    'run': me.usuario_nuevo.run,
                    'email': me.usuario_nuevo.email,
                    'clave_uno': me.usuario_nuevo.clave_uno,
                    'clave_dos': me.usuario_nuevo.clave_dos,
                    'mailing': me.usuario_nuevo.mailing
                }).then(function (response) {
                    window.location.href = "/home";
                }).catch(function (error) {
                    if (error.response.status == 422){
                        me.validationErrors = error.response.data.errors;
                    }
                });
            },
            mostrar_botones_login(){
                if(this.usuario_login.run.length == 0 || this.usuario_login.password.length == 0){
                    this.estados.boton_login_registrate = 1;
                    this.estados.boton_login_inicia = 0;
                }

                if(this.usuario_login.run.length > 0 || this.usuario_login.password.length > 0) {
                    this.estados.boton_login_registrate = 0;
                    this.estados.boton_login_inicia = 1;
                }
            },
            mostrar_botones_registrate(){
                if(this.usuario_nuevo.tipo_persona == 0 || this.usuario_nuevo.nombre.length == 0 || this.usuario_nuevo.run.length == 0 || this.usuario_nuevo.email.length == 0 || this.usuario_nuevo. clave_uno.length == 0 || this.usuario_nuevo.clave_dos.length == 0){
                    this.estados.boton_registro_inicia = 1;
                    this.estados.boton_registro_registrarse = 0;
                }

                if(this.usuario_nuevo.tipo_persona > 0 || this.usuario_nuevo.nombre.length > 0 || this.usuario_nuevo.run.length > 0 || this.usuario_nuevo.email.length > 0 || this.usuario_nuevo.clave_uno.length > 0 || this.usuario_nuevo.clave_dos.length > 0) {
                    this.estados.boton_registro_inicia = 0;
                    this.estados.boton_registro_registrarse = 1;
                }
            },
            limpiar_registro(){
                this.usuario_nuevo.tipo_persona = 0;
                this.usuario_nuevo.nombre = '';
                this.usuario_nuevo.run = '';
                this.usuario_nuevo.email = '';
                this.usuario_nuevo.clave_uno = '';
                this.usuario_nuevo.clave_dos = '';
                this.usuario_nuevo.mailing = false;

                this.mostrar_botones_registrate();
            },
            limpiar_login(){
                this.usuario_login.run = '';
                this.usuario_login.password = '';

                this.mostrar_botones_login();
            },
            cerrar_modal(){
                this.recuperar_password.email = ""
                this.$refs['recuperar_cuenta'].hide()
            },
            recuperar_password(){
                let me = this;

                axios.post('/usuario/recuperar/password',{
                    'correo': me.recuperar_cuenta.email
                }).then(function (response) {
                    me.cerrar_modal();

                    Vue.$toast.open({
                        message: response.data.mensaje,
                        type: response.data.clase,
                        duration: 5000
                    });
                }).catch(function (error) {
                    Vue.$toast.open({
                        message: 'Hemos tenido inconvenientes en tu solicitud. Por favor intenta nuevamente!',
                        type: 'error',
                        duration: 5000
                    });
                });

            }
        },
        mounted(){
            this.mostrar_botones_login();
            this.mostrar_botones_registrate();
        }
    }
</script>

<style>
    .boton_login {
        border-bottom-right-radius: 40px !important;
        color:  #1E2F13 !important;
        background-color: #E8ECD1 !important;
    }
</style>
