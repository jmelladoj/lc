<template>
    <div class="page-wrapper">
        <b-container fluid>
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Servicios</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <ol class="breadcrumb">
                            <li><a href="https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber" target="_blank" aria-expanded="false" class="breadcrumb-item active h3 pl-1 pr-1"><i class="fa fa-youtube"></i></a></li>
                            <li><a href="https://www.facebook.com/prevencion.lebenco.3" target="_blank" aria-expanded="false" class="breadcrumb-item active h3 pl-1 pr-1"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/prevencionlebenco.cl/?hl=es-la" target="_blank" aria-expanded="false" class="breadcrumb-item active h3 pl-1 pr-1"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/prevenci%C3%B3n-lebenco-62b632184/" target="_blank" aria-expanded="false" class="breadcrumb-item active h3 pl-1 pr-1"><i class="fa fa-linkedin"></i></a></li>
                        </ol>
                        <b-button @click="actualizarPagina()" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza información de la página servicios"><i class="fa fa-plus-circle"></i> Actualizar página</b-button>
                        <b-button @click="abrirModal(1)" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un servicio a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Serivios</b-button>
                    </div>                    
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid>
                                <b-row>
                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter" placeholder="Escribe para buscar" />
                                            <b-input-group-append>
                                            <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6" class="my-1">
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

                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Dirección" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortDirection" slot="append">
                                            <option value="asc">Asc</option> <option value="desc">Desc</option>
                                            <option value="last">Último</option>
                                            </b-form-select>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Por página" class="mb-0">
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
                                    :items="items"
                                    :fields="fields"
                                    :current-page="currentPage"
                                    :per-page="perPage"
                                    :filter="filter"
                                    :sort-by.sync="sortBy"
                                    :sort-desc.sync="sortDesc"
                                    :sort-direction="sortDirection"
                                    @filtered="onFiltered"
                                >

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
                                <b-img  :src="servicio.imagen_url" fluid id="img_servicio" center name="img_servicio" class="imagen-servicio"></b-img>
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
                    imagen_url: ''
                },
                modal_servicio: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null
            }
        },  
        computed:{
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods:{
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
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
            mensaje(clase, mensaje) {
                Swal.fire({
                    type: clase,
                    title: mensaje,
                    showConfirmButton: true,
                    timer: 2000
                });
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
                axios.get('/pagina/servicios').then(function (response) {
                    me.items = response.data.servicios;
                    me.totalRows = me.items.length;
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

                axios.post('servicio/crear/actualizar',formData).then(function (response) {
                    me.listarServicios();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                    me.mensaje('success', mensaje);
                }).catch(function (error) {
                    console.error(error);
                });
            },
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el servicio?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.post('/servicio/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarServicios();
                            me.mensaje('success', 'El Servicio ha sido borrado!');
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
            limpiarDatosServicio(){
                this.servicio.id = 0;
                this.servicio.nombre = '';
                this.servicio.descripcion = '';
                this.servicio.imagen_url = null;             
            }
        },
        mounted() {
            this.listarMensajeServicios();
            this.listarServicios();
        }
    }
</script>
