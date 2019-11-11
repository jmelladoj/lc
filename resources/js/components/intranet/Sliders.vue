<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Sliders</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega una slider a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Slider</b-button>
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
                                    <b-img :src="'storage/' + data.item.url_imagen" fluid center alt="Slider" class="imagen"></b-img>
                                </template>

                                <template v-slot:cell(acciones)="row">
                                    <b-button size="xs" variant="success" title="Agregar ubicaciones" @click="abrirModalUbicaciones(row.item)">
                                        <i class="fa fa-plus"></i>
                                    </b-button>

                                    <b-button size="xs" variant="warning" title="Actualizar slider" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <b-button size="xs" variant="danger" title="Eliminar slider" @click="borrar(row.item.id)">
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
            
            <ValidationObserver ref="observer_slider" v-slot="{ valid }">
                <b-modal ref="modal_slider" :title="modal_slider.titulo" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-form-group label="Texto de Slider">
                            <ValidationProvider name="texto" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.texto"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="Nombre de Slider">
                            <ValidationProvider name="color de letra" rules="required" v-slot="{ errors }">
                                <swatches v-model="slider.color" inline></swatches>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="Imagen (Rec. 1920px ancho X 1280px alto | JPG, JPEG y PNG)">
                            <ValidationProvider name="imagen" rules="required|image" v-slot="{ errors, validate }">
                                <b-img  :src="slider.url_imagen" fluid id="img_slider" center name="img_slider" class="imagen"></b-img>
                                <b-form-file id="imagen_slider" name="imagen_slider" accept="image/*" placeholder="Sin archivo" @change="mostrarFoto($event)" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="¿Redirección a?">
                            <ValidationProvider name="redirección" rules="required" v-slot="{ errors }">
                                <b-form-select v-model="slider.link" class="mb-3">
                                    <option :value="0">Sin redirección</option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_slider.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_slider.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
                        <b-button size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>

            <b-modal ref="modal_ubicaciones" title="Asignar ubicaciones" no-close-on-backdrop scrollable>
                <b-form>
                    <b-form-group label="Ubicaciones de Slider">
                        <b-row>
                            <b-col>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="inicio" v-model="slider.inicio">
                                    <label class="custom-control-label" for="inicio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inicio</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="descanso_uno" v-model="slider.descanso_uno">
                                    <label class="custom-control-label" for="descanso_uno">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Descanso uno</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="descanso_dos" v-model="slider.descanso_dos">
                                    <label class="custom-control-label" for="descanso_dos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Descanso dos</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="pagina_nosotros" v-model="slider.pagina_nosotros">
                                    <label class="custom-control-label" for="pagina_nosotros">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Página nosotros</label>
                                </div>
                            </b-col>
                            <b-col>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="pagina_contacto" v-model="slider.pagina_contacto">
                                    <label class="custom-control-label" for="pagina_contacto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Página contácto</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="pagina_comunidad" v-model="slider.pagina_comunidad">
                                    <label class="custom-control-label" for="pagina_comunidad">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Página comunidad</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="pagina_servicios" v-model="slider.pagina_servicios">
                                    <label class="custom-control-label" for="pagina_servicios">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Página servicios</label>
                                </div>
                            </b-col>
                        </b-row>
                    </b-form-group>
                </b-form>

                <template slot="modal-footer">
                    <b-button size="md" variant="success" @click="actualizarUbicaciones()"> Guardar </b-button>
                    <b-button size="md" variant="danger" @click="cerrarModalUbicaciones()"> Cerrar </b-button>
                </template>
            </b-modal>

        </b-container>

    </div>
</template>

<script>
    const items = [];

    export default {
        data() {
            return {
                slider: {
                    id: 0,
                    texto: '',
                    color: '',
                    url_imagen: '',
                    link: 0,
                    inicio: 0,
                    descanso_uno: 0,
                    descanso_dos: 0,
                    pagina_nosotros: 0,
                    pagina_contacto: 0,
                    pagina_comunidad: 0,
                    pagina_servicios: 0
                },
                modal_slider: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'texto', label: 'NOMBRE', sortable: true, class: 'text-left' },
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
                    $('#imagen_slider').attr('src', e.target.result);
                }

                if(e.target.files[0]){
                    reader.readAsDataURL(e.target.files[0]);
                    this.slider.url_imagen = URL.createObjectURL(e.target.files[0]);
                }
            },
            listarSliders (){
                let me=this;
                axios.get('/sliders').then(function (response) {
                    me.items = response.data.sliders;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                let formData = new FormData();
                let imagen_slider = document.querySelector('#imagen_slider');
                formData.append('imagen_slider', imagen_slider.files[0]);
                
                formData.append('slider_id', this.slider.id);
                formData.append('texto', this.slider.texto);
                formData.append('color', this.slider.color);
                formData.append('link', this.slider.link);
                formData.append('inicio', this.slider.inicio);
                formData.append('descanso_uno', this.slider.descanso_uno);
                formData.append('descanso_dos', this.slider.descanso_dos);
                formData.append('pagina_nosotros', this.slider.pagina_nosotros);
                formData.append('pagina_contacto', this.slider.pagina_contacto);
                formData.append('pagina_comunidad', this.slider.pagina_comunidad);
                formData.append('pagina_servicios', this.slider.pagina_servicios);

                axios.post('slider/crear/actualizar',formData).then(function (response) {
                    me.listarSliders();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                    me.mensaje('success', mensaje);
                }).catch(function (error) {
                    console.error(error);
                });
            },
            actualizarUbicaciones(){
                let me = this;

                axios.post('slider/ubicaciones/actualizar',{
                    'slider_id': me.slider.id,
                    'inicio': me.slider.inicio,
                    'descanso_uno': me.slider.descanso_uno,
                    'descanso_dos': me.slider.descanso_dos,
                    'pagina_nosotros': me.slider.pagina_nosotros,
                    'pagina_contacto': me.slider.pagina_contacto,
                    'pagina_comunidad': me.slider.pagina_comunidad,
                    'pagina_servicios': me.slider.pagina_servicios
                }).then(function (response) {
                    me.listarSliders();
                    me.cerrarModalUbicaciones();
                    me.mensaje('success', 'Registro actualizado exitosamente');
                }).catch(function (error) {
                    console.error(error);
                });
            },
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el Slider?',
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
                        axios.post('/slider/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarSliders();
                            me.mensaje('success', 'El Slider ha sido borrado!');
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
                this.modal_slider.titulo = "";
                this.modal_slider.accion = 0;
                this.$refs['modal_slider'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosSlider();

                if(accion == 1){
                    me.modal_slider.titulo = "Agregar Slider";
                    me.modal_slider.accion = 1;
                } else if(accion == 2){
                    me.modal_slider.titulo = "Modificar Slider";
                    me.modal_slider.accion = 2;

                    me.slider.id = data['id'];
                    me.slider.texto = data['texto'];
                    me.slider.color = data['color'];
                    me.slider.link = data['link'];
                    me.slider.url_imagen = 'storage/' + data['url_imagen'];
                }

                this.$refs['modal_slider'].show();
            },
            abrirModalUbicaciones(data = []){
                let me = this;
                this.limpiarDatosSlider();

                this.slider.id = data['id'];
                this.slider.inicio = data['inicio'];
                this.slider.descanso_uno = data['descanso_uno'];
                this.slider.descanso_dos = data['descanso_dos'];
                this.slider.pagina_nosotros = data['pagina_nosotros'];
                this.slider.pagina_contacto = data['pagina_contacto'];
                this.slider.pagina_comunidad = data['pagina_comunidad'];
                this.slider.pagina_servicios = data['pagina_servicios'];

                this.$refs['modal_ubicaciones'].show();
            },
            cerrarModalUbicaciones(){
                this.slider.id = 0;
                this.$refs['modal_ubicaciones'].hide();
            },
            limpiarDatosSlider(){
                this.slider.id = 0;
                this.slider.texto = '';
                this.slider.color = '';
                this.slider.link = '';
                this.slider.url_imagen = null;
                this.inicio = 0;
                this.descanso_uno = 0;
                this.descanso_dos = 0;
                this.pagina_nosotros = 0;
                this.pagina_contacto = 0;
                this.pagina_comunidad = 0;
                this.pagina_servicios = 0;                
            }
        },
        mounted() {
            this.listarSliders();
        }
    }
</script>