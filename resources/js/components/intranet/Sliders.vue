<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Sliders generales</h4></b-col>
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

                                <template v-slot:cell(dirigido)="data">
                                    <label v-if="data.item.tipo_persona == null">Todos</label>
                                    <label v-else-if="data.item.tipo_persona == 1">Personas</label>
                                    <label v-else-if="data.item.tipo_persona == 2">Pymes</label>
                                    <label v-else-if="data.item.tipo_persona == 3">Estudiantes</label>
                                </template>

                                <template v-slot:cell(seccion)="data">
                                    <label v-if="data.item.link == '/intranet/1'">Sección perfil</label>
                                    <label v-else-if="data.item.link == '/intranet/2'">Sección solicitar documento</label>
                                    <label v-else-if="data.item.link == '/intranet/3'">Sección sorteos</label>
                                    <label v-else-if="data.item.link == '/intranet/4'">Sección promociones</label>
                                    <label v-else-if="data.item.link == '/intranet/6'">Sección seminarios</label>
                                    <label v-else-if="data.item.link == '/intranet/7'">Sección terreno</label>
                                    <label v-else-if="data.item.link == '/intranet/8'">Sección recomiéndanos</label>
                                    <label v-else-if="data.item.link == '/intranet/11'">Sección subir documento</label>
                                    <label v-else-if="data.item.link == '/intranet/12'">Sección recargar</label>
                                </template>

                                <template v-slot:cell(imagen)="data">
                                    <b-img :src="'storage/' + data.item.url_imagen" fluid center alt="Slider" height="150" class="imagen"></b-img>
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
                        <b-form-group>
                            <ValidationProvider name="título" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.texto" placeholder="Título"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-row>
                            <b-col>
                                <b-form-group label="Tamaño de letra">
                                    <ValidationProvider name="Tamaño de letra" rules="required" v-slot="{ errors }">
                                        <b-form-radio v-model="slider.letra_titulo" name="letra_titulo" value="46">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tamaño título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_titulo" name="letra_titulo" value="36">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tamaño sub título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_titulo" name="letra_titulo" value="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tamaño parrafo</b-form-radio>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Alineación de texto">
                                    <ValidationProvider name="Alineación de texto" rules="required" v-slot="{ errors }">
                                        <b-form-radio v-model="slider.alineacion_titulo" name="alineacion_titulo" value="text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Derecha</b-form-radio>
                                        <b-form-radio v-model="slider.alineacion_titulo" name="alineacion_titulo" value="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Izquierda</b-form-radio>
                                        <b-form-radio v-model="slider.alineacion_titulo" name="alineacion_titulo" value="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Centrado</b-form-radio>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-form-group>
                            <ValidationProvider name="subtítulo" rules="min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.subtexto" placeholder="Subtítulo"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-row>
                            <b-col>
                                <b-form-group label="Tamaño de letra">
                                    <ValidationProvider name="Tamaño de letra" rules="required" v-slot="{ errors }">
                                        <b-form-radio v-model="slider.letra_sub_titulo" name="letra_sub_titulo" value="46">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tamaño título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_sub_titulo" name="letra_sub_titulo" value="36">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tamaño sub título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_sub_titulo" name="letra_sub_titulo" value="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tamaño parrafo</b-form-radio>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Alineación de texto">
                                    <ValidationProvider name="Alineación de texto" rules="required" v-slot="{ errors }">
                                        <b-form-radio v-model="slider.alineacion_sub_titulo" name="alineacion_sub_titulo" value="text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Derecha</b-form-radio>
                                        <b-form-radio v-model="slider.alineacion_sub_titulo" name="alineacion_sub_titulo" value="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Izquierda</b-form-radio>
                                        <b-form-radio v-model="slider.alineacion_sub_titulo" name="alineacion_sub_titulo" value="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Centrado</b-form-radio>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>


                        <b-row>
                            <b-col class="text-center">
                                <b-form-group label="Color de título">
                                    <ValidationProvider name="color de título" rules="required" v-slot="{ errors }">
                                        <swatches v-model="slider.color" :colors="colors" show-fallback popover-to="left"></swatches>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col class="text-center">
                                <b-form-group label="Color de subtítulo">
                                    <ValidationProvider name="color de subtítulo" v-slot="{ errors }">
                                        <swatches v-model="slider.subcolor" :colors="colors" show-fallback popover-to="left"></swatches>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-form-group label="Imagen (1080px alto como minímo | JPG, JPEG y PNG)">
                            <ValidationProvider name="imagen" rules="required" v-slot="{ errors, validate }">
                                <b-img v-if="slider.url_imagen != null" :src="slider.url_imagen" fluid id="img_slider" center name="img_slider" class="imagen"></b-img>
                                <b-form-file id="imagen_slider" name="imagen_slider" accept="image/*" placeholder="Sin archivo" @change="mostrarFoto($event)" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group>
                            <ValidationProvider name="redirección" rules="required" v-slot="{ errors }">
                                <b-form-select v-model="slider.link" class="mb-3">
                                    <option :value="0" selected>Sin redirección</option>
                                    <option :value="1" selected>Sección mi perfil</option>
                                    <option :value="2" selected>Sección pide documento</option>
                                    <option :value="3" selected>Sección sorteos</option>
                                    <option :value="4" selected>Sección promociones</option>
                                    <option :value="6" selected>Sección seminarios</option>
                                    <option :value="7" selected>Sección visitas a terreno</option>
                                    <option :value="8" selected>Sección recomiéndanos</option>
                                    <option :value="11" selected>Sección subir documento</option>
                                    <option :value="12" selected>Sección recargar</option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group>
                            <ValidationProvider name="segmento de personas" v-slot="{ errors }">
                                <b-form-select v-model="slider.tipo_persona" class="mb-3">
                                    <option :value="null" selected>Para todos los Clientes</option>
                                    <option :value="1" selected>Solo para Personas</option>
                                    <option :value="2" selected>Solo para Pymes</option>
                                    <option :value="3" selected>Solo para Estudiantes</option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <div class="w-100">
                            <b-spinner class="float-left" variant="success" label="Spinning" v-show="spinner.estado == 1"></b-spinner>

                            <b-button class="float-right" :disabled="!valid || modal_slider.accion == 0" v-show="modal_slider.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                            <b-button class="float-right" v-show="modal_slider.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
                            <b-button class="float-right" size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
                        </div>
                    </template>
                </b-modal>
            </ValidationObserver>

            <b-modal ref="modal_ubicaciones" title="Asignar ubicaciones" no-close-on-backdrop scrollable>
                <b-form>
                    <b-form-group label="Ubicaciones de Slider">
                        <b-row>
                            <b-col>
                                <div class="custom-control custom-checkbox">
                                    <b-form-checkbox v-model="slider.inicio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inicio</b-form-checkbox>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <b-form-checkbox v-model="slider.descanso_uno">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Descanso uno</b-form-checkbox>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <b-form-checkbox v-model="slider.descanso_dos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descanso dos</b-form-checkbox>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <b-form-checkbox v-model="slider.pagina_nosotros">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Página nosotros</b-form-checkbox>
                                </div>
                            </b-col>
                            <b-col>
                                <div class="custom-control custom-checkbox">
                                    <b-form-checkbox v-model="slider.pagina_contacto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Página contácto</b-form-checkbox>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <b-form-checkbox v-model="slider.pagina_comunidad">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Página comunidad</b-form-checkbox>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <b-form-checkbox v-model="slider.pagina_servicios">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Página servicios</b-form-checkbox>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <b-form-checkbox v-model="estado_checkbox" id="todo" name="todo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ texto_checkbox }} </b-form-checkbox>
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
                spinner: {
                    estado: 0
                },
                slider: {
                    id: 0,
                    texto: '',
                    subtexto: '',
                    color: '#E8ECD1',
                    subcolor: '#E8ECD1',
                    url_imagen: null,
                    link: 0,
                    tipo_persona: null,
                    inicio: false,
                    descanso_uno: false,
                    descanso_dos: false,
                    pagina_nosotros: false,
                    pagina_contacto: false,
                    pagina_comunidad: false,
                    pagina_servicios: false,
                    letra_titulo: '46',
                    alineacion_titulo: 'text-center',
                    letra_sub_titulo: '36',
                    alineacion_sub_titulo: 'text-center'
                },
                estado_checkbox: false,
                colors: ['#E8ECD1', '#8AB733', '#3F8A24', '#1E2F13', '#D4AF37', '#D7552A', '#0070C0', '#FFFF99' ,''],
                modal_slider: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'texto', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'dirigido', label: 'Dirigido', sortable: true, class: 'text-left' },
                    { key: 'seccion', label: 'Sección', sortable: true, class: 'text-left' },
                    { key: 'imagen', label: 'Imagen', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
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
            },
            texto_checkbox() {
                return this.estado_checkbox == true ? 'Desmarcar todos' : 'Marcar todos'
            }
        },
        watch: {
            estado_checkbox: function(){
                this.slider.inicio = this.estado_checkbox;
                this.slider.descanso_uno = this.estado_checkbox;
                this.slider.descanso_dos = this.estado_checkbox;
                this.slider.pagina_nosotros = this.estado_checkbox;
                this.slider.pagina_contacto = this.estado_checkbox;
                this.slider.pagina_comunidad = this.estado_checkbox;
                this.slider.pagina_servicios = this.estado_checkbox;
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
                me.spinner.estado = 1;
                me.modal_slider.accion = 0;

                formData.append('imagen_slider', imagen_slider.files[0]);

                formData.append('slider_id', this.slider.id);
                formData.append('texto', this.slider.texto);
                formData.append('color', this.slider.color);
                formData.append('subtexto', this.slider.subtexto);
                formData.append('subcolor', this.slider.subcolor);
                formData.append('link', this.slider.link);
                formData.append('tipo_persona', this.slider.tipo_persona);
                formData.append('inicio', this.slider.inicio);
                formData.append('descanso_uno', this.slider.descanso_uno);
                formData.append('descanso_dos', this.slider.descanso_dos);
                formData.append('pagina_nosotros', this.slider.pagina_nosotros);
                formData.append('pagina_contacto', this.slider.pagina_contacto);
                formData.append('pagina_comunidad', this.slider.pagina_comunidad);
                formData.append('pagina_servicios', this.slider.pagina_servicios);

                formData.append('letra_titulo', this.slider.letra_titulo);
                formData.append('alineacion_titulo', this.slider.alineacion_titulo);
                formData.append('letra_sub_titulo', this.slider.letra_sub_titulo);
                formData.append('alineacion_sub_titulo', this.slider.alineacion_sub_titulo);

                axios.post('slider/crear/actualizar',formData).then(function (response) {
                    me.listarSliders();
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

                    Vue.$toast.open({
                        message: 'Registro actualizado exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            },
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el Slider?',
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
                        axios.post('/slider/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarSliders();

                            Vue.$toast.open({
                                message: 'El Slider ha sido borrado!',
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
                this.modal_slider.titulo = "";
                this.modal_slider.accion = 0;
                this.spinner.estado = 0;
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

                    me.slider.id = data.id;
                    me.slider.texto = data.texto;
                    me.slider.color = data.color;
                    me.slider.subtexto = data.subtexto;
                    me.slider.subcolor = data.subcolor;
                    me.slider.link = data.link.replace('/intranet/', '');
                    me.slider.tipo_persona = data.tipo_persona;
                    me.slider.url_imagen = 'storage/' + data.url_imagen;
                    me.slider.letra_titulo = data.letra_titulo
                    me.slider.alineacion_titulo = data.alineacion_titulo
                    me.slider.letra_sub_titulo = data.letra_sub_titulo
                    me.slider.alineacion_sub_titulo = data.alineacion_sub_titulo
                }

                this.$refs['modal_slider'].show();
            },
            abrirModalUbicaciones(data = []){
                let me = this;
                //this.limpiarDatosSlider();

                this.estado_checkbox = false;

                if(parseInt(data.inicio) == 1 && parseInt(data.descanso_uno) == 1 && parseInt(data.descanso_dos) == 1 && parseInt(data.pagina_nosotros) == 1 && parseInt(data.pagina_contacto) == 1 && parseInt(data.pagina_comunidad) == 1 && parseInt(data.pagina_servicios) == 1){
                    this.estado_checkbox = true;
                } else {
                    this.estado_checkbox = false;
                }

                this.slider.id = data.id;
                this.slider.inicio = parseInt(data.inicio) == 1 ? true : false;
                this.slider.descanso_uno = parseInt(data.descanso_uno) == 1 ? true : false;
                this.slider.descanso_dos = parseInt(data.descanso_dos) == 1 ? true : false;
                this.slider.pagina_nosotros = parseInt(data.pagina_nosotros) == 1 ? true : false;
                this.slider.pagina_contacto = parseInt(data.pagina_contacto) == 1 ? true : false;
                this.slider.pagina_comunidad = parseInt(data.pagina_comunidad) == 1 ? true : false;
                this.slider.pagina_servicios = parseInt(data.pagina_servicios) == 1 ? true : false;

                this.$refs['modal_ubicaciones'].show();
            },
            cerrarModalUbicaciones(){
                this.slider.id = 0;
                this.$refs['modal_ubicaciones'].hide();
            },
            limpiarDatosSlider(){
                this.slider.id = 0;
                this.slider.texto = '';
                this.slider.color = '#E8ECD1';
                this.slider.subtexto = '';
                this.slider.subcolor = '#E8ECD1';
                this.slider.link = 0;
                this.slider.url_imagen = null;
                this.slider.tipo_persona = null;
                this.slider.inicio = false;
                this.slider.descanso_uno = false;
                this.slider.descanso_dos = false;
                this.slider.pagina_nosotros = false;
                this.slider.pagina_contacto = false;
                this.slider.pagina_comunidad = false;
                this.slider.pagina_servicios = false;
                this.estado_checkbox = false;
                this.slider.letra_titulo = '46',
                this.slider.alineacion_titulo = 'text-center'
                this.slider.letra_sub_titulo = '36',
                this.slider.alineacion_sub_titulo = 'text-center'
            }
        },
        mounted() {
            this.listarSliders();
        }
    }
</script>

<style>
    .vue-swatches__wrapper {
        width: auto !important;
    }

    .vue-swatches__fallback__wrapper {
        width: auto !important;
    }

    .vue-swatches__swatch {
        height: 30px !important;
        width: 30px !important;
    }


    select option:hover, select option:focus, select option:active, select option:checked{
        background-color: #E8ECD1 !important;
    }

    .custom-file:focus, .custom-file:focus{
        border-color: #8AB733;
        outline: 0;
        box-shadow: 0 0 0 1px rgba(138, 183, 51);
    }

</style>
