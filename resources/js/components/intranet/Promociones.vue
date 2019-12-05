<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Promociones</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button v-if="tipo_usuario < 3" @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega una promoción a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Promoción</b-button>
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
                                    <b-img :src="'storage/' + data.item.url_imagen" fluid center alt="Promocion" class="imagen"></b-img>
                                </template>

                                <template v-slot:cell(acciones)="row">
                                    <b-button v-show="tipo_usuario < 3" size="xs" variant="warning" title="Actualizar promocion" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <b-button v-show="tipo_usuario < 3" size="xs" variant="danger" title="Eliminar promocion" @click="borrar(row.item.id)">
                                        <i class="fa fa-trash"></i>
                                    </b-button>

                                    <label for="" class="label-control" v-show="tipo_usuario == 3"> Sin acciones</label>
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
            
            <ValidationObserver ref="observer_promocion" v-slot="{ valid }">
                <b-modal ref="modal_promocion" :title="modal_promocion.titulo" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-form-group label="Título de Promocion">
                            <ValidationProvider name="título" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="promocion.titulo"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="Fecha de Promoción">
                            <ValidationProvider name="fecha" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="date" v-model="promocion.fecha"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="Imagen (Rec. 1920px ancho X 1280px alto | JPG, JPEG y PNG)">
                            <ValidationProvider name="imagen" rules="required|image" v-slot="{ errors, validate }">
                                <b-img  :src="promocion.url_imagen" fluid id="img_promocion" center name="img_promocion" class="imagen"></b-img>
                                <b-form-file id="imagen_promocion" name="imagen_promocion" accept="image/*" placeholder="Sin archivo" @change="mostrarFoto($event)" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="¿A qué usuarios va dirigido?">
                            <ValidationProvider name="categorias usuario" rules="" v-slot="{ errors }">
                                <b-form-select v-model="promocion.categoria_usuario" class="mb-3">
                                    <option :value="null">Todos</option>
                                    <option v-for="(categoria, index) in categorias" :key="index" :value="categoria.id" v-text="categoria.nombre"></option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_promocion.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_promocion.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
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
        props:[
            'tipo_usuario', 'tipo'
        ],
        data() {
            return {
                promocion: {
                    id: 0,
                    titulo: '',
                    fecha: '',
                    url_imagen: '',
                    categoria_usuario: null
                },
                modal_promocion: {
                    titulo: '',
                    accion: 0
                },
                categorias: [],
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'titulo', label: 'NOMBRE', sortable: true, class: 'text-left' },
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
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            mostrarFoto(e){
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagen_promocion').attr('src', e.target.result);
                }

                if(e.target.files[0]){
                    reader.readAsDataURL(e.target.files[0]);
                    this.promocion.url_imagen = URL.createObjectURL(e.target.files[0]);
                }
            },
            listarPromociones (){
                let me=this;
                axios.get('/promociones/' + this.tipo).then(function (response) {
                    me.items = response.data.promociones;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarCategorias (){
                let me=this;
                axios.get('/categorias/usuario').then(function (response) {
                    me.categorias = response.data.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                let formData = new FormData();
                let imagen_promocion = document.querySelector('#imagen_promocion');
                formData.append('imagen_promocion', imagen_promocion.files[0]);
                
                formData.append('promocion_id', this.promocion.id);
                formData.append('titulo', this.promocion.titulo);
                formData.append('fecha', this.promocion.fecha);
                formData.append('categoria_usuario', this.promocion.categoria_usuario);

                axios.post('promocion/crear/actualizar',formData).then(function (response) {
                    me.listarPromociones();
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
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el Promoción?',
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
                        axios.post('/promocion/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarPromociones();

                            Vue.$toast.open({
		                        message: 'La promoción ha sido borrada!',
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
                this.modal_promocion.titulo = "";
                this.modal_promocion.accion = 0;
                this.$refs['modal_promocion'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosPromocion();

                if(accion == 1){
                    me.modal_promocion.titulo = "Agregar Promoción";
                    me.modal_promocion.accion = 1;
                } else if(accion == 2){
                    me.modal_promocion.titulo = "Modificar Promoción";
                    me.modal_promocion.accion = 2;

                    me.promocion.id = data['id'];
                    me.promocion.titulo = data['titulo'];
                    me.promocion.fecha = data['fecha'];
                    me.promocion.categoria_usuario = data['categoria_usuario'] == null ? null : data['categoria_usuario'];
                    me.promocion.url_imagen = 'storage/' + data['url_imagen'];
                }

                this.$refs['modal_promocion'].show();
            },
            limpiarDatosPromocion(){
                this.promocion.id = 0;
                this.promocion.titulo = '';
                this.promocion.valor = 0;
                this.promocion.categoria_usuario = null;
                this.promocion.url_imagen = null;             
            }
        },
        mounted() {
            this.listarPromociones();
            this.listarCategorias();
        }
    }
</script>