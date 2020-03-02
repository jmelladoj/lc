<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Servicios</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="actualizarPagina()" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza información de la página servicios"><i class="fa fa-refresh"></i> Actualizar página</b-button>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un servicio a la plataforma"><i class="fa fa-plus-circle"></i> Agregar</b-button>
                    </div>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid class="mb-5">
                                <b-row>
                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter" placeholder="Escribe para buscar" />
                                            <b-input-group-append>
                                            <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Ordenar" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortBy" :options="sortOptions">
                                            <option slot="first" :value="null">-- nada --</option>
                                            </b-form-select>
                                            <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                            <option :value="false">Asc</option> <option :value="true">Desc</option>
                                            </b-form-select>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="4" label="Por página" class="mb-0">
                                        <b-form-select :options="pageOptions" v-model="perPage" />
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <!-- Main table element -->
                                <b-table
                                    show-empty
                                    responsive
                                    striped
                                    borderless
                                    outlined
                                    small
                                    hover
                                    stacked="sm"
                                    :items="items"
                                    :fields="fields"
                                    :current-page="currentPage"
                                    :per-page="perPage"
                                    :filter="filter"
                                    :sort-by.sync="sortBy"
                                    :sort-desc.sync="sortDesc"
                                    :sort-direction="sortDirection"
                                    @filtered="onFiltered">

                                    <template slot="empty">
                                        <center><h5>No hay registros para mostrar.</h5></center>
                                    </template>

                                    <template slot="emptyfiltered">
                                        <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                    </template>

                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>

                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="success" title="Agregar detalle" @click="abrir_modal_detalle(row.item)">
                                            <i class="fa fa-plus"></i>
                                        </b-button>

                                        <b-button size="xs" variant="warning" title="Actualizar servicio" @click="abrirModal(2, row.item)">
                                            <i class="fa fa-pencil"></i>
                                        </b-button>

                                        <b-button size="xs" variant="danger" title="Eliminar servicio" @click="borrar(row.item.id)">
                                            <i class="fa fa-trash"></i>
                                        </b-button>
                                    </template>

                                </b-table>

                                <b-row>
                                    <b-col>
                                        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-3" align="fill"/>
                                    </b-col>
                                </b-row>
                            </b-container>
                        </b-form-group>
                    </b-card>

                    <b-card>
                        <b-form-group label="Mensaje">
                            <b-form-textarea v-model="pagina.mensaje" placeholder="Ingresa el mensaje ..." rows="3" max-rows="6"></b-form-textarea>
                        </b-form-group>
                    </b-card>
                </b-col>
            </b-row>

            <ValidationObserver ref="observer_servicio" v-slot="{ valid }">
                <b-modal ref="modal_servicio" :title="modal_servicio.titulo" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-form-group label="Nombre de Servicio">
                            <ValidationProvider name="nombre" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="servicio.nombre"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="Descripción de servicio">
                            <ValidationProvider name="descripción" rules="required|min:3" v-slot="{ errors }">
                                <b-form-textarea v-model="servicio.descripcion" placeholder="Ingresa el mensaje ..." rows="3" max-rows="6"></b-form-textarea>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="Imagen (Rec. 150px ancho X 150px alto | JPG, JPEG y PNG)">
                            <ValidationProvider name="imagen" rules="required|image" v-slot="{ errors, validate }">
                                <b-img v-if="servicio.imagen_url != null" :src="servicio.imagen_url" fluid id="img_servicio" center name="img_servicio" class="maxima-altura"></b-img>
                                <b-form-file id="imagen_servicio" name="imagen_servicio" accept="image/*" placeholder="Sin archivo" @change="mostrarFoto($event)" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_servicio.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_servicio.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
                        <b-button size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>

            <ValidationObserver ref="observer_detalle" v-slot="{ valid }">
                <b-modal ref="modal_sub_servicio" size="lg" :title="modal_sub_servicio.titulo" no-close-on-backdrop scrollable>
                    <b-row>
                        <b-col>
                            <b-form>
                                <b-form-group label="Nombre de sub servicio">
                                    <ValidationProvider name="nombre" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="sub_servicio.nombre"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>

                                <b-form-group label="Descripción de sub servicio">
                                    <ValidationProvider name="descripción" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-textarea v-model="sub_servicio.descripcion" placeholder="Ingresa el mensaje ..." rows="3" max-rows="6"></b-form-textarea>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-form>
                        </b-col>
                        <b-col>
                            <b-form-group>
                                <b-container fluid>
                                    <b-row>
                                        <b-col md="4" class="my-1">
                                            <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                            <b-input-group>
                                                <b-form-input v-model="filter_sub_servicio" placeholder="Escribe para buscar" />
                                                <b-input-group-append>
                                                <b-button :disabled="!filter_sub_servicio" @click="filter_sub_servicio = ''">Limpiar</b-button>
                                                </b-input-group-append>
                                            </b-input-group>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="4" class="my-1">
                                            <b-form-group label-cols-sm="3" label="Ordenar" class="mb-0">
                                            <b-input-group>
                                                <b-form-select v-model="sortBy_sub_servicio" :options="sortOptions_sub_servicio">
                                                <option slot="first" :value="null">-- nada --</option>
                                                </b-form-select>
                                                <b-form-select :disabled="!sortBy_sub_servicio" v-model="sortDesc_sub_servicio" slot="append">
                                                <option :value="false">Asc</option> <option :value="true">Desc</option>
                                                </b-form-select>
                                            </b-input-group>
                                            </b-form-group>
                                        </b-col>

                                        <b-col md="4" class="my-1">
                                            <b-form-group label-cols-sm="4" label="Por página" class="mb-0">
                                            <b-form-select :options="pageOptions_sub_servicio" v-model="perPage_sub_servicio" />
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <!-- Main table element -->
                                    <b-table
                                        show-empty
                                        responsive
                                        striped
                                        borderless
                                        outlined
                                        small
                                        hover
                                        stacked="sm"
                                        :items="items_sub_servicio"
                                        :fields="fields_sub_servicio"
                                        :current-page="currentPage_sub_servicio"
                                        :per-page="perPage_sub_servicio"
                                        :filter="filter_sub_servicio"
                                        :sort-by.sync="sortBy_sub_servicio"
                                        :sort-desc.sync="sortDesc_sub_servicio"
                                        :sort-direction="sortDirection_sub_servicio"
                                        @filtered="onFiltered_sub_servicio">

                                        <template slot="empty">
                                            <center><h5>No hay registros para mostrar.</h5></center>
                                        </template>

                                        <template slot="emptyfiltered">
                                            <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                        </template>

                                        <template v-slot:cell(index)="data">
                                            {{ data.index + 1 }}
                                        </template>

                                        <template v-slot:cell(acciones)="row">
                                            <b-button size="xs" variant="success" title="Agregar detalle" @click="abrir_modal_detalle(row.item)">
                                                <i class="fa fa-plus"></i>
                                            </b-button>

                                            <b-button size="xs" variant="warning" title="Actualizar subservicio" @click="editar_sub_servicio(row.item)">
                                                <i class="fa fa-pencil"></i>
                                            </b-button>

                                            <b-button size="xs" variant="danger" title="Eliminar servicio" @click="borrar_sub_servicio(row.item.id)">
                                                <i class="fa fa-trash"></i>
                                            </b-button>
                                        </template>

                                    </b-table>

                                    <b-row>
                                        <b-col>
                                            <b-pagination :total-rows="totalRows_sub_servicio" :per-page="perPage_sub_servicio" v-model="currentPage_sub_servicio" class="my-3" align="fill"/>
                                        </b-col>
                                    </b-row>
                                </b-container>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" size="md" variant="success" @click="crear_actualizar_sub_servicio(1)"> Guardar </b-button>
                        <b-button size="md" variant="danger" @click="cerrar_modal_sub_servicio()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>

        </b-container>

    </div>
</template>

<script>
    const items = [];

    export default {
        data() {
            return {
                pagina: {
                    mensaje: ''
                },
                servicio: {
                    id: 0,
                    nombre: '',
                    descripcion: '',
                    imagen_url: null
                },
                sub_servicio: {
                    id: 0,
                    nombre: '',
                    descripcion: ''
                },
                modal_servicio: {
                    titulo: '',
                    accion: 0
                },
                modal_sub_servicio: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                items_sub_servicio: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                fields_sub_servicio: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                currentPage_sub_servicio: 1,
                perPage_sub_servicio: 10,
                totalRows_sub_servicio: 0,
                pageOptions_sub_servicio: [10, 25, 50, 100],
                sortBy_sub_servicio: null,
                sortDesc_sub_servicio: false,
                sortDirection_sub_servicio: 'asc',
                filter_sub_servicio: null
            }
        },
        computed:{
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            },
            sortOptions_sub_servicio() {
                return this.fields_sub_servicio.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods:{
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            onFiltered_sub_servicio(filteredItems) {
                this.totalRows_sub_servicio = filteredItems.length
                this.currentPage_sub_servicio = 1
            },
            mostrarFoto(e){
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagen_servicio').attr('src', e.target.result);
                }

                if(e.target.files[0]){
                    reader.readAsDataURL(e.target.files[0]);
                    this.servicio.imagen_url = URL.createObjectURL(e.target.files[0]);
                }
            },
            listarMensajeServicios(){
                let me=this;
                axios.get('/pagina/servicios/mensaje').then(function (response) {
                    me.pagina.mensaje = response.data.pagina.mensaje_uno;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarServicios (){
                let me=this;
                axios.get('/pagina/servicios/intranet').then(function (response) {
                    me.items = response.data.servicios;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_sub_servicios (){
                let me=this;
                axios.get('/pagina/subservicios/' + me.servicio.id).then(function (response) {
                    me.items_sub_servicio = response.data.servicios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPagina(){
                let me = this;

                axios.post('/pagina/servicios/actualizar',{
                    'mensaje': me.pagina.mensaje
                }).then(function (response) {
                    Swal.fire({
                        type: 'success',
                        title: 'Página actualizada exitosamente',
                        showConfirmButton: true,
                        timer: 2000
                    });
                }).catch(function (error) {
                    console.error(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                let formData = new FormData();
                let imagen_servicio = document.querySelector('#imagen_servicio');
                formData.append('imagen_servicio', imagen_servicio.files[0]);

                formData.append('servicio_id', this.servicio.id);
                formData.append('nombre', this.servicio.nombre);
                formData.append('descripcion', this.servicio.descripcion);

                axios.post('/pagina/servicio/crear/actualizar',formData).then(function (response) {
                    me.listarServicios();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';

                    Vue.$toast.open({
                        message: mensaje,
                        type: 'success',
                        duration: 5000
                    });
                }).catch(function (error) {
                    console.error(error);
                });
            },
            crear_actualizar_sub_servicio(accion){
                let me = this;

                axios.post('/pagina/subservicio/crear/actualizar',{
                    'sub_servicio_id': me.sub_servicio.id,
                    'servicio_id': me.servicio.id,
                    'nombre': me.sub_servicio.nombre,
                    'descripcion': me.sub_servicio.descripcion
                }).then(function (response) {
                    me.listar_sub_servicios();
                    me.limpiar_datos_sub_servicio();
                    me.modal_sub_servicio.accion = 1

                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';

                    Vue.$toast.open({
                        message: mensaje,
                        type: 'success',
                        duration: 5000
                    });
                }).catch(function (error) {
                    console.error(error);
                });
            },
            editar_sub_servicio(data = []){
                this.modal_sub_servicio.accion = 2

                this.sub_servicio.id = data.id
                this.sub_servicio.nombre = data.nombre
                this.sub_servicio.descripcion = data.descripcion
            },
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el servicio?',
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
                        axios.post('/pagina/servicio/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarServicios();

                            Vue.$toast.open({
		                        message: 'El servicio ha sido borrado!',
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            borrar_sub_servicio(id){
                Swal.fire({
                    title: '¿Deseas borrar el sub servicio?',
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
                        axios.post('/pagina/subservicio/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_sub_servicios();

                            Vue.$toast.open({
		                        message: 'El subservicio ha sido borrado!',
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
                this.modal_servicio.titulo = "";
                this.modal_servicio.accion = 0;
                this.$refs['modal_servicio'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosServicio();

                if(accion == 1){
                    me.modal_servicio.titulo = "Agregar Servicio";
                    me.modal_servicio.accion = 1;
                } else if(accion == 2){
                    me.modal_servicio.titulo = "Modificar Servicio";
                    me.modal_servicio.accion = 2;

                    me.servicio.id = data['id'];
                    me.servicio.nombre = data['nombre'];
                    me.servicio.descripcion = data['descripcion'];
                    me.servicio.imagen_url = 'storage/' + data['imagen_url'];
                }

                this.$refs['modal_servicio'].show();
            },
            abrir_modal_detalle(data = []){
                this.modal_sub_servicio.titulo = 'Agregar detalle a ' + data.nombre
                this.modal_sub_servicio.accion = 1
                this.servicio.id = data.id

                this.listar_sub_servicios()
                this.limpiar_datos_sub_servicio()

                this.$refs['modal_sub_servicio'].show();
            },
            cerrar_modal_sub_servicio(){
                this.modal_sub_servicio.titulo = ''
                this.modal_sub_servicio.accion = 0

                this.$refs['modal_sub_servicio'].hide();
            },
            limpiarDatosServicio(){
                this.servicio.id = 0;
                this.servicio.nombre = '';
                this.servicio.descripcion = '';
                this.servicio.imagen_url = null;
            },
            limpiar_datos_sub_servicio(){
                this.sub_servicio.id = 0;
                this.sub_servicio.nombre = '';
                this.sub_servicio.descripcion = '';

            }
        },
        mounted() {
            this.listarMensajeServicios();
            this.listarServicios();
        }
    }
</script>

<style>
    .maxima-altura {
        height: 150px !important;
    }
</style>
