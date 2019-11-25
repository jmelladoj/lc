<template>
    <section class="sec-padding-login">
        <div class="container">
            <b-row v-show="errors.length > 0" class="justify-content-around">
                <b-alert variant="danger" show>
                    <ul>
                        <li v-for="(error, index) in errors" :key="index" v-text="error[0]"></li>
                    </ul>
                </b-alert>
            </b-row>
            <div class="row">
                <div class="offset-md-2 col-md-8" v-show="formulario == 0">
                    <div class="my-account-box mb-4" id="ingreso" name="ingreso">
                        <form class="form-full-height">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Inicia tu sesión</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="mt-0 btn btn--secondary space--1 btn-sm" @click="formulario = 1">... Regístrate</button>
                                </div>
                            </div>                       
                            
                            <p class="large text-justify">Bienvenido a tu comunidad LebenCo.</p>
                            <p class="form-field-wrapper">
                                <input class="input--lg form-full run" v-model="usuario_login.run" autocomplete="run" type="text" placeholder="RUN personal o RUT si eres una Pyme" required>
                            </p>
                            <p class="form-field-wrapper">
                                <input class="input--lg form-full" v-model="usuario_login.password" autocomplete="current-password" type="password" placeholder="Ingresa tu clave" required>
                            </p>
                            <p class="form-field-wrapper">
                                <label class="">
                                    <input class="" v-model="usuario_login.remember" type="checkbox">
                                    <span>Recuérdame</span>
                                </label>
                            </p>
                            <p class="form-field-wrapper form-row">
                                <button type="button" class="btn btn--lg btn--secondary" name="login" value="Log in" @click="ingresar">Ingresar</button>
                            </p>
                            <p class="form-field-wrapper lost_password">
                                <a href="#" class="sale-color">Olvide mi clave</a>
                            </p>
                        </form>
                    </div>
                </div>
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
                usuario_login: {
                    run: '',
                    password: '',
                    remember: false
                }
            }
        },  
        methods:{
            ingresar(){
                let me=this;
                axios.post('/login',{
                    'run': me.usuario_login.run,
                    'password': me.usuario_login.password,
                    'remember': me.usuario_login.remember
                })
                .catch(function (error) {
                    this.setValidationErrors(response);
                });
            }
        },
        mounted() {

        }
    }
</script>