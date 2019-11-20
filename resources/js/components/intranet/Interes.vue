<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Link de Interés</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un sitio de interés a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Link de Interés</b-button>
                    </div>                    
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid class="mb-5">
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

                                <template v-slot:cell(imagen)="data">
                                    <b-img :src="'storage/' + data.item.url_imagen" fluid center alt="Sitio de interés" class="imagen"></b-img>
                                </template>

                                <template v-slot:cell(acciones)="row">
                                    <b-button size="xs" variant="warning" title="Actualizar sitio de interés" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <b-button size="xs" variant="danger" title="Eliminar sitio de interés" @click="borrar(row.item.id)">
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
                </b-col>
            </b-row>
            
            <ValidationObserver ref="observer_link" v-slot="{ valid }">
                <b-modal ref="modal_sitio" :title="modal_sitio.titulo" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-form-group label="Nombre de sitio de Interés">
                            <ValidationProvider name="nombre" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="sitio.nombre"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>


                        <b-form-group label="Imagen (Rec. 1920px ancho X 1280px alto | JPG, JPEG y PNG)">
                            <ValidationProvider name="imagen" rules="required|image" v-slot="{ errors, validate }">
                                <b-img  :src="sitio.url_imagen" id="img_sitio" center name="img_sitio" class="imagen"></b-img>
                                <b-form-file id="imagen_sitio" name="imagen_sitio" accept="image/*" placeholder="Sin archivo" @change="mostrarFoto($event)" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_sitio.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_sitio.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
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
                sitio: {
                    id: 0,
                    nombre: '',
                    url_imagen: null
                },
                modal_sitio: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', sortable: true, class: 'text-left' },
                    { key: 'imagen', label: 'IMAGEN', sortable: true, class: 'text-center' },
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
            mensaje(clase, mensaje) {
                Swal.fire({
                    type: clase,
                    title: mensaje,
                    showConfirmButton: true,
                    timer: 2000
                });
            },
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            mostrarFoto(e){
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagen_sitio').attr('src', e.target.result);
                }

                if(e.target.files[0]){
                    reader.readAsDataURL(e.target.files[0]);
                    this.sitio.url_imagen = URL.createObjectURL(e.target.files[0]);
                }
            },
            listarSitios (){
                let me=this;
                axios.get('/sitios').then(function (response) {
                    me.items = response.data.sitios;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                let formData = new FormData();
                let imagen_sitio = document.querySelector('#imagen_sitio');
                formData.append('imagen_sitio', imagen_sitio.files[0]);
                
                formData.append('sitio_id', this.sitio.id);
                formData.append('nombre', this.sitio.nombre);

                axios.post('sitio/crear/actualizar',formData).then(function (response) {
                    me.listarSitios();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                    me.mensaje('success', mensaje);
                }).catch(function (error) {
                    console.error(error);
                });
            },
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el Sitio de interés?',
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
                        axios.post('/sitio/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarSitios();
                            me.mensaje('success', 'El sitio de interés ha sido borrado!');
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
                this.modal_sitio.titulo = "";
                this.modal_sitio.accion = 0;
                this.$refs['modal_sitio'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosSitios();

                if(accion == 1){
                    me.modal_sitio.titulo = "Agregar Sitio de Interés";
                    me.modal_sitio.accion = 1;
                } else if(accion == 2){
                    me.modal_sitio.titulo = "Modificar Sitio de Interés";
                    me.modal_sitio.accion = 2;

                    me.sitio.id = data['id'];
                    me.sitio.nombre = data['nombre'];
                    me.sitio.url_imagen = 'storage/' + data['url_imagen'];
                }

                this.$refs['modal_sitio'].show();
            },
            limpiarDatosSitios(){
                this.sitio.id = 0;
                this.sitio.sitio = '';
                this.sitio.url_imagen = null;               
            }
        },
        mounted() {
            this.listarSitios();
        }
    }
</script>