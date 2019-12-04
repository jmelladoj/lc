<template>
    <section class="sec-padding-login">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Contáctate con nosotros</h2>
                    <form class="Contact-form">
                        <ValidationObserver ref="observer_categoria" v-slot="{ valid }">
                            <div class="row">
                                <div class="form-field-wrapper col-md-6">
                                    <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                        <input v-model="usuario.nombre" class="input--lg form-full" placeholder="Nombre completo o Razón social si eres una Pyme" size="30" aria-required="true" required="" type="text">
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-field-wrapper col-md-6">
                                    <ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
                                        <input v-model="usuario.email" class="input--lg form-full" placeholder="Ingresa tu correo electrónico" size="30" aria-required="true" required="" type="email">
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-field-wrapper col-md-6">
                                    <ValidationProvider name="asunto" rules="required|min:3" v-slot="{ errors }">
                                        <input v-model="usuario.asunto" class="input--lg form-full" placeholder="Ingresa el asunto del mensaje" size="30" aria-required="true" required="" type="text">
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-field-wrapper col-md-6">
                                    <ValidationProvider name="teléfono" rules="required|numeric|digits:9" v-slot="{ errors }">
                                        <input v-model="usuario.telefono" class="input--lg form-full" placeholder="Ingresa tu número telefónico para ser contactado Ej. 56 9 8745 432" size="30" aria-required="true" required="" type="text">
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="form-field-wrapper col-md-6">
                                    <ValidationProvider name="mensaje" rules="required|min:20" v-slot="{ errors }">
                                        <b-form-textarea v-model="usuario.mensaje" class="input--lg form-full" placeholder="Tu consulta es muy importante para nosotros" rows="7" no-resize required></b-form-textarea>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-field-wrapper col-md-6 mb-0">
                                    <p class="large text-justify">La comunidad LebenCo. dispone de herramientas para Estudiantes del área, Prevencionistas o Personas encargadas de la prevención y nuestras Pymes.</p> 
                                    <p class="form-field-wrapper">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="estudiante" name="tipo_persona" v-model="usuario.tipo_persona" class="custom-control-input" value="3">
                                                    <label class="custom-control-label" for="estudiante"> Estudiante</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="persona" name="tipo_persona" v-model="usuario.tipo_persona" class="custom-control-input" value="1">
                                                    <label class="custom-control-label" for="persona"> Prevencionista</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="empresa" name="tipo_persona" v-model="usuario.tipo_persona" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="empresa"> Pyme</label>
                                                </div>
                                            </div>
                                        </div>
                                    </p>
                                    <br>
                                    <div class="row">
                                        <div class="form-field-wrapper col-md-12">
                                            <input class="submit btn btn--lg btn--primary" value="Enviar mensaje" :disabled="!valid" type="button" @click="contactar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ValidationObserver>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-information">
                        <div class="form-field-wrapper">
                            <label style="font-size: 17px;">Si necesitas asistencia técnica sobre la plataforma, puedes encontrarnos en</label>
                            <p>
                                <i class="ti-email left"></i>soporte@prevencionlebenco.cl
                            </p>
                        </div>
                    </div>
                    <div class="contact-information">
                        <div class="form-field-wrapper">
                            <label style="font-size: 17px;">Para todo lo demás, puedes encontrarnos en</label>
                            <p>
                                <i class="ti-email left"></i>contacto@prevencionlebenco.cl
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data(){
            return {
                usuario: {
                    nombre: '',
                    email: '',
                    asunto: '',
                    telefono: null,
                    mensaje: '',
                    tipo_persona: 1
                }
            }
        },
        methods:{
            mensaje(clase, mensaje) {
                Swal.fire({
                    position: 'bottom-end',
                    type: clase,
                    title: mensaje,
                    showConfirmButton: true,
                    timer: 2000
                });
            },
            listar_usuario(){
                if(user != undefined){
                    this.usuario.nombre = this.user.nombre;
                    this.usuario.email = this.user.email;
                    this.usuario.telefono = this.user.telefono;
                    this.usuario.tipo_persona = this.user.tipo_persona;
                }
            },
            contactar(){
                let me=this;
                Swal.fire({
                    title: '¿Deseas contactarnos?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8AB733',
                    cancelButtonColor: '#d7552a',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.post('/contacto/generar', {
                            'nombre': this.usuario.nombre, 
                            'email': this.usuario.email, 
                            'asunto': this.usuario.asunto, 
                            'telefono': this.usuario.telefono, 
                            'mensaje': this.usuario.mensaje, 
                            'tipo_persona': this.usuario.tipo_persona
                        }).then(function (response) {
                            me.mensaje(response.data.clase, response.data.mensaje);
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            }
        },
        mounted() {
            if(this.user){
                this.listar_usuario();
            }
        }
    }
</script>

<style scoped>
    textarea {
        font-size: 14px !important;
        height: 100% !important;
    }
</style>