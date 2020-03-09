<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor" v-text="titulo"></h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un documento a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Documento</b-button>
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
                                    id="panel-table"
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

                                <template v-slot:cell(valor)="data">
                                    {{ data.item.valor | currency }}
                                </template>


                                <template v-slot:cell(acciones)="row">
                                    <b-button size="xs" variant="success" title="Descargar documento" @click="descargar(row.item.id)">
                                        <i class="fa fa-file"></i>
                                    </b-button>

                                    <b-button v-show="tipo_usuario < 3" size="xs" variant="warning" title="Actualizar Documento" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <b-button v-show="tipo_usuario < 3" size="xs" variant="danger" title="Eliminar Documento" @click="borrar(row.item.id)">
                                        <i class="fa fa-trash"></i>
                                    </b-button>
                                </template>

                                </b-table>

                                <b-row>
                                    <b-col>
                                    <b-pagination
                                    v-model="currentPage"
                                    :total-rows="totalRows"
                                    :per-page="perPage"
                                    align="fill"
                                    size="sm"
                                    class="my-0"
                                    ></b-pagination>

                                    </b-col>
                                </b-row>
                            </b-container>
                        </b-form-group>
                    </b-card>
                </b-col>
            </b-row>

            <ValidationObserver ref="observer_slider" v-slot="{ valid }">
                <b-modal ref="modal_documento" :title="modal_documento.titulo" size="lg" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-row>
                            <b-col xs="12" sm="12" :md="tipo_usuario < 3 ? 6 : 12">
                                <b-form-group>
                                    <ValidationProvider name="titulo" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="documento.titulo" placeholder="Título"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col xs="12" sm="12" :md="tipo_usuario < 3 ? 6 : 12" v-if="tipo_usuario < 3">
                                <b-form-group>
                                    <ValidationProvider name="Valor" :rules="tipo_usuario < 3 ? 'required|numeric|min_value:0' : ''" v-slot="{ errors }">
                                        <b-form-input type="number" v-model="documento.valor" placeholder="Valor" ></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-form-group>
                            <ValidationProvider name="Descripción" rules="required|min:3" v-slot="{ errors }">
                                <b-form-textarea v-model="documento.descripcion"  rows="3" max-rows="6" placeholder="Descripción"></b-form-textarea>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-row>
                            <b-col xs="12" sm="12" :md="tipo_usuario < 3 ? 6 : 12" v-if="tipo_usuario < 3">
                                <b-form-group  class="mb-2">
                                    <ValidationProvider name="código" :rules="tipo_usuario < 3 ? 'required|min:3' : ''" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="documento.codigo" placeholder="Código"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col xs="12" sm="12" :md="tipo_usuario < 3 ? 6 : 12">
                                <b-form-group class="mb-2">
                                    <ValidationProvider name="categoria" rules="required:min_value:0" v-slot="{ errors }">
                                        <b-form-select v-model="documento.categoria_id" class="mb-3">
                                            <option :value="0">Sin categoría</option>
                                            <option v-for="(categoria,index) in categorias" :key="index" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </b-form-select>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-form-group v-if="tipo_usuario < 3" label="¿En dónde se mostrara el documento?">
                            <b-row>
                                <b-col xs="12" sm="12" md="5">
                                    <b-form-checkbox v-model="documento.seccion_nuevo" value="1" unchecked-value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sección nuevos documentos</b-form-checkbox>
                                </b-col>
                                <b-col xs="12" sm="12" md="5">
                                    <b-form-checkbox v-model="documento.seccion_descargados" value="1" unchecked-value="0" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sección preferidos</b-form-checkbox>
                                </b-col>
                            </b-row>
                        </b-form-group>

                        <b-form-group>
                            <ValidationProvider name="documento" rules="required|ext:pdf,docx,xlsx,mp4,pptx,mp3" v-slot="{ errors, validate }">
                                <b-form-file id="documento" name="documento" accept=".pdf,.docx,.xlsx,.mp4,.pptx,.mp3" placeholder="Documento" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group>
                            <ValidationProvider name="vista previa" v-slot="{ errors, validate }">
                                <b-form-file id="documento_uno" name="documento_uno" accept="image/*" placeholder="Vista previa uno" @change="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group>
                            <b-form-file id="documento_dos" name="documento_dos" accept="image/*" placeholder="Vista previa dos"></b-form-file>
                        </b-form-group>

                    </b-form>

                    <template slot="modal-footer">
                        <div class="w-100">
                            <b-spinner class="float-left" variant="success" label="Spinning" v-show="spinner.estado == 1"></b-spinner>

                            <b-button class="float-right" :disabled="!valid || modal_documento.accion == 0" v-show="modal_documento.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                            <b-button class="float-right" v-show="modal_documento.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
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
        props: [
            'tipo', 'tipo_documento', 'titulo', 'tipo_usuario'
        ],
        data() {
            return {
                spinner: {
                    estado: 0
                },
                documento: {
                    id: 0,
                    titulo: '',
                    descripcion: '',
                    codigo: '',
                    documento_url: null,
                    valor: null,
                    categoria_id: 0,
                    seccion_nuevo: 0,
                    seccion_descargados: 0,
                    estado: 0
                },
                modal_documento: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'titulo', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'nombre_categoria', label: 'Categoría', sortable: true, class: 'text-left' },
                    { key: 'valor', label: 'Valor', sortable: true, class: 'text-left' },
                    { key: 'extension_documento', label: 'Tipo de documento', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                categorias: [],
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
            listarCategorias (){
                let me=this;
                axios.get('/categorias').then(function (response) {
                    me.categorias = response.data.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarDocumentos (){
                let me=this;
                axios.get('/documentos/' + this.tipo).then(function (response) {
                    me.items = response.data.documentos;
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
                me.modal_documento.accion = 0;

                let documento = document.querySelector('#documento');
                formData.append('documento', documento.files[0]);

                let documento_uno = document.querySelector('#documento_uno');
                formData.append('documento_uno', documento_uno.files[0]);

                let documento_dos = document.querySelector('#documento_dos');
                formData.append('documento_dos', documento_dos.files[0]);

                formData.append('documento_id', this.documento.id);
                formData.append('titulo', this.documento.titulo);
                formData.append('descripcion', this.documento.descripcion);
                formData.append('codigo', this.documento.codigo);
                formData.append('documento_url', this.documento.documento_url);
                formData.append('valor', this.documento.valor == null ? 0 : this.documento.valor);
                formData.append('categoria_id', this.documento.categoria_id);
                formData.append('estado', this.documento.estado);
                formData.append('seccion_nuevo', this.documento.seccion_nuevo);
                formData.append('seccion_descargados', this.documento.seccion_descargados);
                formData.append('estado', this.documento.estado);

                axios.post('documento/crear/actualizar',formData).then(function (response) {
                    me.listarDocumentos();
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
                    title: '¿Deseas borrar el Documento?',
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
                        axios.post('/documento/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarDocumentos();

                            Vue.$toast.open({
		                        message: 'El documento ha sido borrado!',
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            descargar(id){
                Swal.fire({
                    title: '¿Deseas descargar el Documento?',
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
                        axios.get('/documento/descargar/' + id).then(function (response) {
                            if(response.data.clase == 'success'){

                            	Vue.$toast.open({
			                        message: 'El dcoumento se descargara pronto!',
			                        type: 'success',
			                        duration: 5000
			                    });

                                const link = document.createElement('a');
                                link.href = '/storage/' + response.data.documento.documento_url;
                                link.download = response.data.documento.titulo + '.' + response.data.documento.extension;
                                document.body.appendChild(link);
                                link.click();
                            } else {

                            	Vue.$toast.open({
			                        message: response.data.mensaje,
			                        type: response.data.clase,
			                        duration: 5000
			                    });
                            }

                        }).catch(function (error) {
                            console.log(error.response.data);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },


            cerrarModal(){
                this.modal_documento.titulo = "";
                this.modal_documento.accion = 0;
                this.spinner.estado = 0;
                this.$refs['modal_documento'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosDocumentos();

                if(accion == 1){
                    me.modal_documento.titulo = "Agregar Documento";
                    me.modal_documento.accion = 1;
                } else if(accion == 2){
                    me.modal_documento.titulo = "Modificar Documento";
                    me.modal_documento.accion = 2;

                    me.documento.id = data['id'];
                    me.documento.titulo = data['titulo'];
                    me.documento.descripcion = data['descripcion'];
                    me.documento.codigo = data['codigo'];
                    me.documento.valor = data['valor'];
                    me.documento.categoria_id = data['id_categoria'];
                    me.documento.seccion_nuevo = data['seccion_nuevo'];
                    me.documento.seccion_descargados = data['seccion_descargados'];
                    me.documento.estado = data['estado'];
                }

                this.$refs['modal_documento'].show();
            },
            limpiarDatosDocumentos(){
                this.documento.id = 0;
                this.documento.titulo = '';
                this.documento.descripcion = '';
                this.documento.codigo = '';
                this.documento.documento_url = null;
                this.documento.valor = null;
                this.documento.categoria_id = 0;
                this.documento.seccion_nuevo = 0;
                this.documento.seccion_descargados = 0;
                this.documento.estado = 0;
            },
            obtener_registros_documentos(){
                this.listarCategorias();
                this.listarDocumentos();
            }
        },
        mounted() {
            let me = this
            me.obtener_registros_documentos();

            Evento.$on('listar_documentos', function () {
                me.obtener_registros_documentos();
            })

        }
    }
</script>
