<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Sliders comunidad</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega una slider de comunidad a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Slider</b-button>
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
                                <b-form-input type="text" v-model="slider.texto_slider" placeholder="Título"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group>
                            <ValidationProvider name="subtítulo" rules="min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.subtexto" placeholder="Subtítulo"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

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

                        <b-form-group>
                            <ValidationProvider name="texto de boton" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.texto_boton" placeholder="Texto de botón"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group>
                            <ValidationProvider name="texto de modal" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.texto_modal" placeholder="Texto de modal"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group>
                            <ValidationProvider name="texto de notificación" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.texto_alerta" placeholder="Texto de notificación"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

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
                                    <option :value="12" selected>Sección recargar</option>
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
                    texto_slider: '',
                    subtexto: '',
                    texto_boton: '',
                    texto_modal: '',
                    texto_alerta: '',
                    color: '#E8ECD1',
                    subcolor: '#E8ECD1',
                    url_imagen: null,
                    link: 0
                },
                colors: ['#E8ECD1', '#8AB733', '#3F8A24', '#1E2F13', '#D4AF37', '#D7552A', '#0070C0', '#FFFF99' ,''],
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
                axios.get('/sliders/comunidad').then(function (response) {
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

                me.spinner.estado = 1;
                me.modal_slider.accion = 0;

                let imagen_slider = document.querySelector('#imagen_slider');
                formData.append('imagen_slider', imagen_slider.files[0]);

                formData.append('slider_id', this.slider.id);
                formData.append('texto_slider', this.slider.texto_slider);
                formData.append('texto_boton', this.slider.texto_boton);
                formData.append('texto_modal', this.slider.texto_modal);
                formData.append('texto_alerta', this.slider.texto_alerta);
                formData.append('color', this.slider.color);
                formData.append('subtexto', this.slider.subtexto);
                formData.append('subcolor', this.slider.subcolor);
                formData.append('link', this.slider.link);

                axios.post('/slider/comunidad/crear/actualizar',formData).then(function (response) {
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
                        axios.post('/slider/comunidad/eliminar',{
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

                    me.slider.id = data['id'];
                    me.slider.texto_slider = data['texto'];
                    me.slider.texto_boton = data['texto_boton'];
                    me.slider.texto_modal = data['texto_modal'];
                    me.slider.texto_alerta = data['texto_alerta'];
                    me.slider.color = data['color'];
                    me.slider.subtexto = data['subtexto'];
                    me.slider.subcolor = data['subcolor'];
                    me.slider.link = data['link'];
                    me.slider.url_imagen = 'storage/' + data['url_imagen'];
                }

                this.$refs['modal_slider'].show();
            },
            limpiarDatosSlider(){
                this.slider.id = 0;
                this.slider.texto_slider = '';
                this.slider.texto_boton = '';
                this.slider.texto_modal = '';
                this.slider.texto_alerta = '';
                this.slider.color = '#E8ECD1';
                this.slider.subtexto = '';
                this.slider.subcolor = '#E8ECD1';
                this.slider.url_imagen = null;
                this.slider.link = 0;
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
</style>
