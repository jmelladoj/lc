<template>
    <div>
        <a href="javascript:void(0)" class="h4" title="Ver perfil de usuario" @click="abrir_modal_perfil">
            <i class="fa fa-user sale-color"></i>
        </a>

        <b-modal ref="modal_perfil" :title="modal_perfil.titulo" size="lg" no-close-on-backdrop>
            <b-form>
                <b-row>
                    <b-col cols="4">
                        <b-card>
                            <center class="mt-1">
                                <img v-bind:src="usuario.url_perfil" alt="Imagen de usuario" class="img-circle mb-2" width="150">
                                <p v-show="usuario.posicion > 0">
                                    <i class="fa fa-star fa-2x text-warning" aria-hidden="true" v-for="index in usuario.posicion" :key="index"></i>
                                </p>
                                <p>
                                    A {{ usuario.likes }} % les gusta esto.
                                </p>
                                <hr>
                                <small class="text-muted">Correo: </small><h6 v-text="usuario.email"></h6><br>
                                <small v-show="usuario.tiene_sitio == 1" class="text-muted">Sitio web: </small><a v-show="usuario.tiene_sitio == 1" href="javascript:void(0)" @click="redireccion()">{{ usuario.sitio_web }}</a>
                            </center>
                        </b-card>

                    </b-col>
                    <b-col cols="8">
                        <b-card>
                            <b-tabs content-class="mt-3">
                                <b-tab title="Datos comerciales" active>
                                    <b-form-group>
                                        <b-form-textarea v-model="usuario.nombre" rows="6" max-rows="6" :readonly="true"></b-form-textarea>
                                    </b-form-group>
                                    <b-form-group  label="Dirección">
                                        <b-form-input type="text" v-model="usuario.direccion" :readonly="true"></b-form-input>
                                    </b-form-group>

                                    <b-row>
                                        <b-col>
                                            <b-form-group label="Teléfono">
                                                <b-input-group prepend="+56 ">
                                                    <b-form-input type="number" v-model="usuario.telefono" :readonly="true"></b-form-input>
                                                </b-input-group>
                                            </b-form-group>
                                        </b-col>
                                        <b-col>
                                            <b-form-group  label="Comuna">
                                                <b-form-input type="text" v-model="usuario.comuna" :readonly="true"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </b-tab>
                                <b-tab title="Comentarios">

                                </b-tab>
                            </b-tabs>
                        </b-card>
                    </b-col>
                </b-row>
            </b-form>

            <template slot="modal-footer">
                <b-button size="md" variant="danger" @click="cerrar_modal_perfil()"> Cerrar </b-button>
            </template>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: [
            'usuario_id'
        ]
        ,
        data(){
            return {
                usuario: {
                    id: 0,
                    nombre: '',
                    email: '',
                    url_perfil: '',
                    posicion: 0,
                    likes: 0,
                    direccion: '',
                    telefono: null,
                    comuna: '',
                    tiene_sitio: 0,
                    sitio_web: ''
                },
                modal_perfil: {
                    titulo: ''
                }
            }
        },
        methods: {
            listar_usuario (){
                let me = this;

                axios.get('/usuario/' + this.usuario_id).then(function (response) {
                    me.usuario.nombre = response.data.usuario.nombre
                    me.usuario.email = response.data.usuario.email
                    me.usuario.url_perfil = response.data.usuario.url_perfil == 'img/perfil.svg' ?  response.data.usuario.url_perfil : 'storage/' + response.data.usuario.url_perfil
                    me.usuario.posicion = response.data.usuario.posicion
                    me.usuario.likes = response.data.usuario.likes
                    me.usuario.direccion = response.data.usuario.direccion
                    me.usuario.telefono = response.data.usuario.telefono
                    me.usuario.comuna = response.data.usuario.nombreComuna
                    me.usuario.tiene_sitio = response.data.usuario.tiene_sitio
                    me.usuario.sitio_web = response.data.usuario.sitio_web
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrar_modal_perfil(){
                this.modal_perfil.titulo = '';
                this.usuario.id = 0;

                this.$refs['modal_perfil'].hide();
            },
            abrir_modal_perfil(){
                let me = this

                this.limpiar_datos_usuario()
                this.usuario.id = this.usuario_id

                this.listar_usuario()
                this.modal_perfil.titulo = 'Te recomendamos a ' +  this.usuario.nombre

                this.$refs['modal_perfil'].show();
            },
            limpiar_datos_usuario(){
                this.usuario.id = 0
                this.usuario.email = ''
                this.usuario.nombre = ''
                this.usuario.url_perfil = ''
                this.usuario.posicion = 0
                this.usuario.likes = 0
                this.usuario.direccion = ''
                this.usuario.telefono = null
                this.usuario.comuna = ''
                this.usuario.tiene_sitio = 0
                this.usuario.sitio_web = ''
            },
            redireccion(){
                window.location = this.usuario.sitio_web
            }
        }
    }
</script>
