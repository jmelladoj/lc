<template>
    <div>
        <a href="javascript:void(0)" class="h4" title="Ver perfil de usuario" @click="abrir_modal_perfil">
            <i class="fa fa-user sale-color"></i>
        </a>

        <b-modal ref="modal_perfil" :title="modal_perfil.titulo" size="xl" no-close-on-backdrop>
            <b-form>
                <b-row>
                    <b-col xs="12" sm="12" md="4">
                        <b-card>
                            <center class="mt-1">
                                <img v-bind:src="usuario.url_perfil" alt="Imagen de usuario" class="mb-2" width="150">
                                <p v-show="usuario.posicion > 0" @click="abrirModalValoracion">
                                    <i class="fa fa-star fa-2x text-warning" aria-hidden="true" v-for="index in usuario.posicion" :key="index"></i>
                                </p>
                                <p>
                                    <span v-if="usuario.like_porcentaje_admin > 0">A {{ usuario.like_porcentaje_admin }} % les gusta esto.</span>
                                    <span v-else>Califica a nuestro socio con tu comentario.</span>
                                </p>
                                <hr>
                                <h6 v-text="usuario.email"></h6><br>
                                <a v-if="usuario.sitio_web" v-bind:href="usuario.sitio_web" target="_blank" class="sale-color">{{ usuario.sitio_web }}</a>
                            </center>
                        </b-card>

                    </b-col>
                    <b-col xs="12" sm="12" md="8">
                        <b-card>
                            <b-tabs content-class="mt-3">
                                <b-tab title="Datos comerciales" active>
                                    <b-form-group>
                                        <b-form-textarea v-model="usuario.descripcion_administrador" rows="6" max-rows="6" :readonly="true"></b-form-textarea>
                                    </b-form-group>
                                    <b-form-group  label="Dirección">
                                        <b-form-input type="text" v-model="usuario.direccion" :readonly="true"></b-form-input>
                                    </b-form-group>

                                    <b-row>
                                        <b-col  xs="12" sm="12" md="6">
                                            <b-form-group label="Teléfono">
                                                <b-input-group prepend="+56 9 ">
                                                    <b-form-input type="number" v-model="usuario.telefono" :readonly="true"></b-form-input>
                                                </b-input-group>
                                            </b-form-group>
                                        </b-col>
                                        <b-col  xs="12" sm="12" md="6">
                                            <b-form-group  label="Comuna">
                                                <b-form-input type="text" v-model="usuario.comuna" :readonly="true"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </b-tab>

                                <b-tab title="Comentarios">
                                    <b-container fluid>
                                        <b-table
                                            show-empty
                                            responsive
                                            striped
                                            borderless
                                            outlined
                                            small
                                            hover
                                            stacked="sm"
                                            :items="items_pyme"
                                            :fields="fields_pyme"
                                            :current-page="currentPage_pyme"
                                            :per-page="perPage_pyme"
                                            :filter="filter_pyme"
                                            :sort-by.sync="sortBy_pyme"
                                            :sort-desc.sync="sortDesc_pyme"
                                            :sort-direction="sortDirection_pyme"
                                            @filtered="onFiltered_pyme">

                                            <template slot="empty">
                                                <center><h5>No hay registros para mostrar.</h5></center>
                                            </template>

                                            <template slot="emptyfiltered">
                                                <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                            </template>

                                            <template v-slot:cell(tipo_votacion)="row">
                                                <label v-text="row.item.tipo_votacion == 1 ? 'Positivo' : 'Negativo'"></label>
                                            </template>
                                        </b-table>
                                    </b-container>
                                </b-tab>
                            </b-tabs>
                        </b-card>
                    </b-col>
                </b-row>
            </b-form>

            <template slot="modal-footer">
                <b-button size="md" variant="danger" class="boton_redondo" @click="cerrar_modal_perfil()"> Cerrar </b-button>
            </template>
        </b-modal>

        <ValidationObserver ref="observer_votacion" v-slot="{ valid }">
            <b-modal ref="modal_votacion" :title="modal_votacion.titulo" size="md" no-close-on-backdrop>
                <b-form>
                    <b-form-group label="Tipo de valoración">
                        <ValidationProvider rules="oneOf:1,2,3" v-slot="{ errors }">
                            <b-form-select v-model="valoracion.tipo">
                                <option :value="null">Selecciona una opción</option>
                                <option :value="1">Positiva</option>
                                <option :value="2">Negativa</option>
                            </b-form-select>
                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                        </ValidationProvider>
                    </b-form-group>

                    <b-form-group v-if="valoracion.tipo" :label="valoracion.tipo == 1 ? '¿Qué te ha gustado de la pyme?' : '¿Qué no te ha gustado de la Pyme?'">
                        <ValidationProvider name="Calificación" rules="required|min:20|max:200" v-slot="{ errors }">
                            <b-form-textarea v-model="valoracion.descripcion" placeholder="Escribe aquí ..." rows="3" max-rows="6"></b-form-textarea>
                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                        </ValidationProvider>
                    </b-form-group>
                </b-form>

                <template slot="modal-footer">
                    <b-button :disabled="!valid" size="md" variant="success" @click="enviarValoracion()"> Guardar </b-button>
                    <b-button size="md" variant="danger" @click="cerrarModalValoracion()"> Cerrar </b-button>
                </template>
            </b-modal>
        </ValidationObserver>
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
                    sitio_web: '',
                    descripcion_administrador: ''
                },
                modal_perfil: {
                    titulo: ''
                },
                items_pyme: [],
                fields_pyme: [
                    { key: 'nombre_usuario', label: 'Autor', sortable: true, class: 'text-left' },
                    { key: 'tipo_votacion', label: 'Tipo comentario', sortable: true, class: 'text-left' },
                    { key: 'descripcion', label: 'Comentario', sortable: true, class: 'text-left' }
                ],
                currentPage_pyme: 1,
                perPage_pyme: 10,
                totalRows_pyme: 0,
                pageOptions_pyme: [10, 25, 50, 100],
                sortBy_pyme: null,
                sortDesc_pyme: false,
                sortDirection_pyme: 'asc',
                filter_pyme: null,
                valoracion: {
                    descripcion: '',
                    tipo: null
                },
                modal_votacion: {
                    titulo: '',
                    accion: 0
                }
            }
        },
        computed: {
            sortOptions_pyme() {
                return this.fields_pyme.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods: {
            onFiltered_pyme(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            abrirModalValoracion(){
                let me = this;

                me.valoracion.descripcion = '';
                me.modal_votacion.titulo = 'Valorando a ' + me.usuario.nombre;

                this.$refs['modal_votacion'].show();
            },
            cerrarModalValoracion(){
                let me = this;

                me.modal_votacion.titulo = '';
                me.modal_votacion.accion = 0;
                this.$refs['modal_votacion'].hide();
            },
            enviarValoracion (){
                let me = this;

                axios.post('/valorar/pyme',{
                    'detalle': me.valoracion.descripcion,
                    'tipo_votacion': me.valoracion.tipo
                }).then(function (response) {
                    me.listar_valoraciones();
                    me.listar_usuario()
                    me.cerrarModalValoracion();
                    me.valoracion.descripcion = ''
                    me.valoracion.tipo = null

                    Vue.$toast.open({
                        message: 'Muchas gracias por tu Calificación',
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            },
            listar_valoraciones(){
                let me=this;
                axios.get('/usuario/valoraciones/' + this.usuario_id).then(function (response) {
                    me.items_pyme = response.data.valoraciones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_usuario (){
                let me = this;

                axios.get('/usuario/' + this.usuario_id).then(function (response) {
                    me.usuario.nombre = response.data.usuario.nombre
                    me.usuario.email = response.data.usuario.email
                    me.usuario.url_perfil = response.data.usuario.url_perfil == 'img/perfil.png' ?  response.data.usuario.url_perfil : 'storage/' + response.data.usuario.url_perfil
                    me.usuario.posicion = response.data.usuario.posicion
                    me.usuario.likes = response.data.usuario.likes
                    me.usuario.direccion = response.data.usuario.direccion
                    me.usuario.telefono = response.data.usuario.telefono
                    me.usuario.comuna = response.data.usuario.nombre_comuna
                    me.usuario.sitio_web = response.data.usuario.sitio_web
                    me.usuario.descripcion_administrador = response.data.usuario.descripcion_administrador

                    me.listar_valoraciones()
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
                this.usuario.sitio_web = ''
                this.usuario.descripcion_administrador = ''
            },
            redirigir_sitio_web(link){
                window.open(link, '_blank');
            }
        }
    }
</script>

<style>
    .boton_redondo {
        border-radius: 10px;
    }
</style>