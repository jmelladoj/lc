<template>
    <section class="sec-padding-login mt-3 mb-3">
        <div class="container">
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
                                    <button type="button" class="mt-0 redondear btn btn-success btn-md text-white" @click="formulario = 1" v-if="estados.boton_login_registrate == 1">... Regístrate</button>
                                </div>
                            </div>

                            <p class="large text-justify">Bienvenido a Comunidad LebenCo.</p>
                            <p class="form-field-wrapper">
                                <input class="input--lg form-full" v-rut:live v-model="usuario_login.run" @blur="mostrar_botones_login" @keyup="mostrar_botones_login" autocomplete="run" type="text" @keyup.enter="ingresar" placeholder="RUN o RUT" required>
                                <errores :errors="validationErrors" :campo="'run'" v-if="validationErrors"> </errores>
                            </p>
                            <p class="form-field-wrapper">
                                <input class="input--lg form-full" v-model="usuario_login.password" @blur="mostrar_botones_login" @keyup="mostrar_botones_login" autocomplete="current-password" type="password" @keyup.enter="ingresar" placeholder="Ingresa tu clave" required>
                                <errores :errors="validationErrors" :campo="'password'" v-if="validationErrors"> </errores>
                            </p>

                            <div class="row">
                                <div class="col-md-3 form-field-wrapper text-left">
                                    <button v-if="estados.boton_login_inicia == 1" type="button" class="btn mt-0 btn btn--secondary space--1 btn-sm boton_login btn-secondary mb-0" name="login" value="Log in" @click="ingresar">Ingresar</button>
                                </div>
                                <div class="col-md-3 form-field-wrapper text-left">
                                    <label class="mt-2">
                                        <input v-model="usuario_login.remember" type="checkbox">
                                        <span>Recuérdame</span>
                                    </label>
                                </div>
                                <div class="col-md-6 form-field-wrapper lost_password text-right">
                                    <label v-b-modal.recuperar_cuenta class="mt-2 mb-0" style="color: #8AB733">Recuperar mi cuenta</label>
                                </div>
                            </div>

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
                                    <button type="button" class="mt-0 redondear btn btn-success btn-md text-white" @click="formulario = 0" v-if="estados.boton_registro_inicia == 1">... Inicia tu sesión</button>
                                </div>
                            </div>

                            <p class="large text-justify">Todo comienza con el primer paso de un Estudiante, Trabajador, Emprendedor, Pymes o Empresas.</p>

                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="estudiante" @change="mostrar_botones_registrate" name="tipo_persona" v-model="usuario_nuevo.tipo_persona" class="custom-control-input" value="3" />
                                            <label class="custom-control-label" for="estudiante"> Estudiante</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="persona" @change="mostrar_botones_registrate" name="tipo_persona" v-model="usuario_nuevo.tipo_persona" class="custom-control-input" value="1" />
                                            <label class="custom-control-label" for="persona"> Persona / Emprendedor</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="empresa" @change="mostrar_botones_registrate" name="tipo_persona" v-model="usuario_nuevo.tipo_persona" class="custom-control-input" value="2" />
                                            <label class="custom-control-label" for="empresa"> Pyme / Empresa</label>
                                        </div>
                                    </div>
                                </div>
                                <errores :errors="validationErrors" :campo="'tipo_persona'" v-if="validationErrors"> </errores>
                            </p>

                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <input class="input--lg form-full" @keyup="mostrar_botones_registrate" v-model="usuario_nuevo.nombre" type="text" placeholder="Nombre completo o Razón social" required>
                                        <errores :errors="validationErrors" :campo="'nombre'" v-if="validationErrors"> </errores>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input id="run" class="input--lg form-full run_nuevo" @keyup="mostrar_botones_registrate" v-rut:live v-model="usuario_nuevo.run" type="text" placeholder="RUN o RUT" required>
                                        <span id="alerta_rut" class="d-none"><span class="d-block alert alert-danger m-t-5">Rut o run invalido</span></span>
                                        <errores :errors="validationErrors" :campo="'run'" v-if="validationErrors"> </errores>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input id="run_confirmacion" class="input--lg form-full run_nuevo_confirmacion" @keyup="mostrar_botones_registrate" v-rut:live v-model="usuario_nuevo.run_confirmacion" type="text" placeholder="Repite RUN o RUT" required>
                                        <span id="alerta_rut_confirmacion" class="d-none"><span class="d-block alert alert-danger m-t-5">Rut o run invalido</span></span>
                                        <span id="alerta_rut_igual" class="d-none"><span class="d-block alert alert-danger m-t-5">Ambos RUN / RUT deben coincidir.</span></span>
                                        <errores :errors="validationErrors" :campo="'run_confirmacion'" v-if="validationErrors"> </errores>
                                    </div>

                                </div>
                            </p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <input class="input--lg form-full" @keyup="mostrar_botones_registrate" v-model="usuario_nuevo.email" type="email" placeholder="Correo electrónico" required>
                                        <errores :errors="validationErrors" :campo="'email'" v-if="validationErrors"> </errores>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input id="clave_uno" class="input--lg form-full" @keyup="mostrar_botones_registrate" v-model="usuario_nuevo.clave_uno" type="password" placeholder="Crea tu clave (6 caracteres)" required>
                                        <errores :errors="validationErrors" :campo="'clave_uno'" v-if="validationErrors"> </errores>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input  id="clave_dos" class="input--lg form-full" @keyup="mostrar_botones_registrate" v-model="usuario_nuevo.clave_dos" type="password" placeholder="Repite esa clave" required>
                                        <errores :errors="validationErrors" :campo="'clave_dos'" v-if="validationErrors"> </errores>
                                        <span id="alerta_pass_igual" class="d-none"><span class="d-block alert alert-danger m-t-5">Ambas contraseñas deben coincidir.</span></span>
                                    </div>
                                </div>
                            </p>
                            <p class="form-field-wrapper text-justify">
                                Sus datos personales se utilizarán con el fin de respaldar su experiencia en nuestro sitio web, administrar el acceso a su cuenta y para otros fines descritos en nuestra <a class="sale-color" href="/politicas" target="_blank">Política</a>, al registrarse usted acepta nuestros Términos y condiciones en el uso de nuestros servicios, que han sido establecidos por Prevención LebenCo. SpA
                            </p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="sale-color">
                                            <input class="" v-model="usuario_nuevo.mailing" type="checkbox">
                                            <span>Quiero recibir notificaciones importantes de la Comunidad LebenCo.</span>
                                        </label>
                                    </div>
                                    <div class="col-md-6 text-right" v-if="estados.boton_registro_registrarse == 1">
                                        <button type="button" class="btn mt-0 btn btn--secondary space--1 btn-sm boton_login btn-secondary" @click="registrar">Registrarme</button>
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
                            <b-button class="redondear" size="md" variant="success" :disabled="!valid" @click="recuperar_password">Recuperar mi cuenta</b-button>
                            <b-button class="redondear" size="md" variant="danger" @click="cerrar_modal"> Cerrar </b-button>
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
                    run_confirmacion: '',
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

                this.validationErrors = ''

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

                this.validationErrors = ''

                axios.post('/register',{
                    'tipo_persona': me.usuario_nuevo.tipo_persona,
                    'nombre': me.usuario_nuevo.nombre,
                    'run': me.usuario_nuevo.run,
                    'run_confirmacion': me.usuario_nuevo.run_confirmacion,
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

                this.limitar_caracteres_run()
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
                this.validationErrors = ''
                this.usuario_nuevo.tipo_persona = 0;
                this.usuario_nuevo.nombre = '';
                this.usuario_nuevo.run = '';
                this.usuario_nuevo.run_confirmacion = ''
                this.usuario_nuevo.email = '';
                this.usuario_nuevo.clave_uno = '';
                this.usuario_nuevo.clave_dos = '';
                this.usuario_nuevo.mailing = false;

                $('#alerta_rut').addClass('d-none')
                $('#alerta_rut_confirmacion').addClass('d-none')
                $('#alerta_rut_igual').addClass('d-none')
                $('#alerta_pass_igual').addClass('d-none')



                this.mostrar_botones_registrate();
            },
            limpiar_login(){
                this.validationErrors = ''
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

            },
            limitar_caracteres_run(){
                if(this.usuario_login.run.length > 12){
                    this.usuario_login.run = this.usuario_login.run.slice(0,12); 
                }
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
        border-radius: 10px 10px 10px 10px !important;
        color:  #1E2F13 !important;
        background-color: #E8ECD1 !important;
    }

    .lost_password {
        margin-top: 0px !important;
    }

    .redondear {
        border-radius: 10px 10px 10px 10px !important;
    }
</style>
