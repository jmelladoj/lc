<template>
    <section class="sec-padding-contacto">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Contáctate con nosotros</h2>
                    <form class="Contact-form">
                        <ValidationObserver ref="observer_contacto" v-slot="{ valid, reset }">
                            <div class="row">
                                <div class="form-field-wrapper col-md-4">
                                    <ValidationProvider name="nombre" rules="required|min:6|alpha_spaces" v-slot="{ errors }">
                                        <input @keyup="cambiar_estado" v-model="usuario.nombre" class="input--lg form-full" placeholder="Nombre completo o Razón social" size="30" aria-required="true" type="text">
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-field-wrapper col-md-4">
                                    <ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
                                        <input @keyup="cambiar_estado" v-model="usuario.email" class="input--lg form-full" placeholder="Ingresa tu correo electrónico" size="30" aria-required="true" type="email">
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-field-wrapper col-md-4">
                                    <ValidationProvider name="teléfono" rules="required|numeric|digits:8" v-slot="{ errors }">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text col-md-12" id="basic-addon1">+ 56 9</span>
                                            </div>
                                            <input @keyup="cambiar_estado" v-model="usuario.telefono" class="input--lg form-full col-md-8" placeholder="Ingresa tu número telefónico" size="30" aria-required="true" type="text">
                                        </div>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-field-wrapper col-md-6">
                                    <ValidationProvider name="asunto" rules="required|min:10" v-slot="{ errors }">
                                        <input @keyup="cambiar_estado" v-model="usuario.asunto" class="input--lg form-full" placeholder="Ingresa el asunto del mensaje" size="30" aria-required="true" type="text">
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-field-wrapper col-md-6">
                                    <ValidationProvider name="tipo_persona" rules="required|oneOf:1,2,3" v-slot="{ errors }">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="estudiante" @change="cambiar_estado" name="tipo_persona" v-model="usuario.tipo_persona" class="custom-control-input" value="3" />
                                                    <label class="custom-control-label" for="estudiante"> Estudiante</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="persona" @change="cambiar_estado" name="tipo_persona" v-model="usuario.tipo_persona" class="custom-control-input" value="1" />
                                                    <label class="custom-control-label" for="persona"> Persona / Emprendedor</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="empresa" @change="cambiar_estado" name="tipo_persona" v-model="usuario.tipo_persona" class="custom-control-input" value="2" />
                                                    <label class="custom-control-label" for="empresa"> Pyme / Empresa</label>
                                                </div>
                                            </div>
                                        </div>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-field-wrapper col-md-6">
                                    <ValidationProvider name="mensaje" rules="required|min:20" v-slot="{ errors }">
                                        <b-form-textarea @keyup="cambiar_estado" v-model="usuario.mensaje" class="input--lg form-full" placeholder="Tu consulta es muy importante para nosotros" rows="5" no-resize></b-form-textarea>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-field-wrapper col-md-6 mb-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="contact-information">
                                                <div class="form-field-wrapper">
                                                    <label style="font-size: 14px;">Si necesitas asistencia técnica sobre la plataforma, puedes encontrarnos en</label>
                                                    <p>
                                                        <i class="ti-email left"></i>soporte@prevencionlebenco.cl
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <div class="form-field-wrapper">
                                                    <label style="font-size: 14px;">Para todo lo demás, puedes encontrarnos en</label>
                                                    <p>
                                                        <i class="ti-email left"></i>contacto@prevencionlebenco.cl
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-field-wrapper col-md-12">
                                            <input v-show="estado_boton == 1" class="submit btn btn--lg btn--primary redondear" value="Enviar mensaje" :disabled="!valid" type="button" @click="contactar(); reset">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ValidationObserver>
                    </form>
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
                    tipo_persona: 0
                },
                estado_boton: 0
            }
        },
        methods:{
            cambiar_estado(){
                if(!this.usuario){
                    if(this.usuario.asunto.length > 0 || this.usuario.mensaje.length > 0 || this.usuario.tipo_persona > 0){
                        this.estado_boton = 1;
                    } else {
                        this.estado_boton = 0;
                    }
                } else {
                    if(this.usuario.nombre.length > 0 ||  this.usuario.email.length > 0 || this.usuario.asunto.length > 0 || this.usuario.telefono > 0 || this.usuario.mensaje.length > 0 || this.usuario.tipo_persona > 0){
                        this.estado_boton = 1;
                    } else {
                        this.estado_boton = 0;
                }
                }
            },
            listar_usuario(){
                this.usuario.nombre = this.user.nombre;
                this.usuario.email = this.user.email;
                this.usuario.telefono = this.user.telefono;
                this.usuario.tipo_persona = this.user.tipo_persona;
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
                        	Vue.$toast.open({
		                        message: response.data.mensaje,
		                        type: response.data.clase,
		                        duration: 5000
                            });

                            me.limpiar_formulario()

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            limpiar_formulario(){
                if(this.user){
                    this.usuario.nombre = '';
                    this.usuario.email = '';
                    this.usuario.telefono = null;
                    this.usuario.tipo_persona = 0;
                    this.estado_boton = 0;
                    this.$refs.observer_contacto.reset()
                }

                this.usuario.asunto = '';
                this.usuario.mensaje = '';
            }
        },
        mounted() {
            if(this.user){
                this.listar_usuario();
            }
            this.cambiar_estado();
        }
    }
</script>

<style scoped>
    textarea {
        font-size: 14px !important;
        height: 85% !important;
        border-color: rgba(0, 0, 0, 0.08) !important;
    }

    textarea::placeholder {
        color: #333;
    }

    .form-control::placeholder {
        color: #333 !important;
        opacity: 0.5;
    }

    .input-group-text {
        font-size: 14px !important;
    }

    textarea:focus[data-v-25e73d5d] {
        border-color: #8AB733 !important;
    }

    .container {
        max-width: 1240px !important;
    }

    #basic-addon1 {
        border-radius: 0px !important;
    }
</style>
