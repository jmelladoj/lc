
text/x-generic SlidersComunidad.vue ( exported SGML document, UTF-8 Unicode text )

<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Sliders comunidad</h4></b-col>
                <b-col xs="12" sm="12" md="7">
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

                                <template v-slot:cell(acciones)="row">
                                    <b-button size="xs" variant="info" title="Duplicar" @click="duplicar_slider(row.item)">
                                        <i class="fa fa-files-o"></i>
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
                <b-modal ref="modal_slider" size="xl" :title="modal_slider.titulo" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-form-group>
                            <ValidationProvider name="título" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.texto_slider" placeholder="Título"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-row>
                            <b-col md="6">
                                <ValidationProvider name="Borde externo letra" rules="numeric|min:0" v-slot="{ errors }">
                                    <b-form-input type="text" v-model="slider.texto_borde_externo" placeholder="Borde de letras expresadas en píxeles"></b-form-input>
                                    <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                </ValidationProvider>                                
                            </b-col>    
                            <b-col md="6">
                                <ValidationProvider name="color de título" rules="" v-slot="{ errors }">
                                    <b-row>
                                        <b-col md="6">
                                            Color para el fondo del texto: 
                                        </b-col>
                                        <b-col>
                                            <swatches v-model="slider.texto_color_fondo" :colors="colors" show-fallback popover-to="left"></swatches>
                                        </b-col>
                                    </b-row>
                                    
                                    <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                </ValidationProvider>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Tamaño de letra">
                                    <ValidationProvider name="Tamaño de letra" rules="required" v-slot="{ errors }">
                                        <b-form-radio v-model="slider.letra_titulo" name="letra_titulo" value="46">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_titulo" name="letra_titulo" value="36">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sub título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_titulo" name="letra_titulo" value="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parrafo</b-form-radio>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col xs="12" sm="12" md="6">
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
                            <b-col md="6">
                                <ValidationProvider name="Borde externo letra" rules="numeric|min:0" v-slot="{ errors }">
                                    <b-form-input type="text" v-model="slider.subtitulo_borde_externo" placeholder="Borde de letras expresadas en píxeles"></b-form-input>
                                    <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                </ValidationProvider>                                
                            </b-col>    
                            <b-col md="6">
                                <ValidationProvider name="color de subtítulo" rules="" v-slot="{ errors }">
                                    <b-row>
                                        <b-col md="6">
                                            Color para el fondo del subtitulo: 
                                        </b-col>
                                        <b-col>
                                            <swatches v-model="slider.subtitulo_color_fondo" :colors="colors" show-fallback popover-to="left"></swatches>
                                        </b-col>
                                    </b-row>
                                    
                                    <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                </ValidationProvider>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Tamaño de letra">
                                    <ValidationProvider name="Tamaño de letra" rules="required" v-slot="{ errors }">
                                        <b-form-radio v-model="slider.letra_sub_titulo" name="letra_sub_titulo" value="46">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_sub_titulo" name="letra_sub_titulo" value="36">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sub título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_sub_titulo" name="letra_sub_titulo" value="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parrafo</b-form-radio>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col xs="12" sm="12" md="6">
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

                        <b-form-group>
                            <ValidationProvider name="Parrafo" rules="min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.parrafo" placeholder="Parrafo"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-row>
                            <b-col md="6">
                                <ValidationProvider name="Borde externo letra" rules="numeric|min:0" v-slot="{ errors }">
                                    <b-form-input type="text" v-model="slider.parrafo_borde_externo" placeholder="Borde de letras expresadas en píxeles"></b-form-input>
                                    <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                </ValidationProvider>                                
                            </b-col>    
                            <b-col md="6">
                                <ValidationProvider name="color de parrafo" rules="" v-slot="{ errors }">
                                    <b-row>
                                        <b-col md="6">
                                            Color para el fondo del parrafo: 
                                        </b-col>
                                        <b-col>
                                            <swatches v-model="slider.parrafo_color_fondo" :colors="colors" show-fallback popover-to="left"></swatches>
                                        </b-col>
                                    </b-row>
                                    
                                    <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                </ValidationProvider>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="6">
                                <b-form-group label="Tamaño de letra">
                                    <ValidationProvider name="Tamaño de letra" rules="required" v-slot="{ errors }">
                                        <b-form-radio v-model="slider.letra_parrafo" name="letra_parrafo" value="46">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_parrafo" name="letra_parrafo" value="36">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sub título</b-form-radio>
                                        <b-form-radio v-model="slider.letra_parrafo" name="letra_parrafo" value="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parrafo</b-form-radio>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group label="Alineación de texto">
                                    <ValidationProvider name="Alineación de texto" rules="required" v-slot="{ errors }">
                                        <b-form-radio v-model="slider.alineacion_parrafo" name="alineacion_parrafo" value="text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Derecha</b-form-radio>
                                        <b-form-radio v-model="slider.alineacion_parrafo" name="alineacion_parrafo" value="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Izquierda</b-form-radio>
                                        <b-form-radio v-model="slider.alineacion_parrafo" name="alineacion_parrafo" value="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Centrado</b-form-radio>
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
                            <b-col class="text-center">
                                <b-form-group label="Color de parrafo">
                                    <ValidationProvider name="color de parrafo" v-slot="{ errors }">
                                        <swatches v-model="slider.parrafo_color" :colors="colors" show-fallback popover-to="left"></swatches>
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
                                <b-form-select v-model="slider.link">
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
                            <ValidationProvider name="Link alternativo uno" rules="min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.link_alternativo_uno" placeholder="Link alternativo uno"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>


                        <b-form-group>
                            <ValidationProvider name="Link alternativo dos" rules="min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="slider.link_alternativo_dos" placeholder="Link alternativo dos"></b-form-input>
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
                    link: 0,
                    letra_titulo: '46',
                    alineacion_titulo: 'text-center',
                    letra_sub_titulo: '36',
                    alineacion_sub_titulo: 'text-center',
                    link_alternativo_uno: '',
                    link_alternativo_dos: '',
                    parrafo: '',
                    parrafo_color: '#E8ECD1',
                    letra_parrafo: '36',
                    alineacion_parrafo: 'text-center',
                    texto_borde_externo: null,
                    texto_color_fondo: "",
                    subtitulo_borde_externo: null,
                    subtitulo_color_fondo: "",
                    parrafo_borde_externo: null,
                    parrafo_color_fondo: ""
                },
                colors: ['#E8ECD1', '#8AB733', '#3F8A24', '#1E2F13', '#D4AF37', '#D7552A', '#0070C0', '#FFFF99' ,''],
                modal_slider: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'texto', label: 'Nombre', sortable: true, class: 'text-left' },
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

                formData.append('letra_titulo', this.slider.letra_titulo);
                formData.append('alineacion_titulo', this.slider.alineacion_titulo);
                formData.append('letra_sub_titulo', this.slider.letra_sub_titulo);
                formData.append('alineacion_sub_titulo', this.slider.alineacion_sub_titulo);

                formData.append('link_alternativo_uno', this.slider.link_alternativo_uno);
                formData.append('link_alternativo_dos', this.slider.link_alternativo_dos);

                formData.append('parrafo', this.slider.parrafo);
                formData.append('parrafo_color', this.slider.parrafo_color);
                formData.append('letra_parrafo', this.slider.letra_parrafo);
                formData.append('alineacion_parrafo', this.slider.alineacion_parrafo);

                formData.append('texto_borde_externo', this.slider.texto_borde_externo);
                formData.append('texto_color_fondo', this.slider.texto_color_fondo);

                formData.append('subtitulo_borde_externo', this.slider.subtitulo_borde_externo);
                formData.append('subtitulo_color_fondo', this.slider.subtitulo_color_fondo);

                formData.append('parrafo_borde_externo', this.slider.parrafo_borde_externo);
                formData.append('parrafo_color_fondo', this.slider.parrafo_color_fondo);

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
            duplicar_slider(id){
                Swal.fire({
                    title: '¿Deseas duplicar el Slider?',
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
                        axios.post('/slider/comunidad/duplicar',{
                            'id': id
                        }).then(function (response) {
                            me.listarSliders();

                            Vue.$toast.open({
                                message: 'El Slider ha sido duplicado!',
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
                    me.slider.link = data['link'].replace('/intranet/', '');
                    me.slider.url_imagen = 'storage/' + data['url_imagen'];
                    me.slider.letra_titulo = data.letra_titulo
                    me.slider.alineacion_titulo = data.alineacion_titulo
                    me.slider.letra_sub_titulo = data.letra_sub_titulo
                    me.slider.alineacion_sub_titulo = data.alineacion_sub_titulo
                    me.slider.link_alternativo_uno = data.link_alternativo_uno
                    me.slider.link_alternativo_dos = data.link_alternativo_dos

                    me.slider.parrafo = data.parrafo
                    me.slider.parrafo_color = data.parrafo_color
                    me.slider.letra_parrafo = data.letra_parrafo
                    me.slider.alineacion_parrafo = data.alineacion_parrafo

                    me.slider.texto_borde_externo =  data.texto_borde_externo == 0 ? null : data.texto_borde_externo 
                    me.slider.texto_color_fondo = data.texto_color_fondo == 'transparent' ? '' : data.texto_color_fondo

                    me.slider.subtitulo_borde_externo =  data.subtitulo_borde_externo == 0 ? null : data.subtitulo_borde_externo 
                    me.slider.subtitulo_color_fondo = data.subtitulo_color_fondo == 'transparent' ? '' : data.subtitulo_color_fondo

                    me.slider.parrafo_borde_externo =  data.parrafo_borde_externo == 0 ? null : data.parrafo_borde_externo 
                    me.slider.parrafo_color_fondo = data.parrafo_color_fondo == 'transparent' ? '' : data.parrafo_color_fondo
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

                this.slider.letra_titulo = '46',
                this.slider.alineacion_titulo = 'text-center'
                this.slider.letra_sub_titulo = '36',
                this.slider.alineacion_sub_titulo = 'text-center'

                this.slider.link_alternativo_uno = ''
                this.slider.link_alternativo_dos = ''

                this.slider.parrafo = ''
                this.slider.parrafo_color = '#E8ECD1'
                this.slider.letra_parrafo = '36'
                this.slider.alineacion_parrafo = 'text-center'

                this.slider.texto_borde_externo = null
                this.slider.texto_color_fondo = ''

                this.slider.subtitulo_borde_externo= null
                this.slider.subtitulo_color_fondo = ''
                
                this.slider.parrafo_borde_externo = null
                this.slider.parrafo_color_fondo = ''
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

