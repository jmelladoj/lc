<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor" v-text="titulo"></h4></b-col>
                <b-col cols="7">
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

                                <template v-slot:cell(nombre_categoria)="data">
                                    {{ data.item.categoria.nombre }}
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
                                        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-3" align="fill"/>
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
                            <b-col>
                                <b-form-group label="Título">
                                    <ValidationProvider name="titulo" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="documento.titulo"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col v-if="tipo_usuario < 3">
                                <b-form-group label="Valor">
                                    <ValidationProvider name="Valor" rules="required|numeric|min_value:0" v-slot="{ errors }">
                                        <b-form-input type="number" v-model="documento.valor"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-form-group label="Descripción">
                            <ValidationProvider name="Descripción" rules="required|min:3" v-slot="{ errors }">
                                <b-form-textarea v-model="documento.descripcion"  rows="3" max-rows="6"></b-form-textarea>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-row>
                            <b-col v-if="tipo_usuario < 3">
                                <b-form-group label="Código">
                                    <ValidationProvider name="código" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="documento.codigo"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col v-if="tipo_usuario < 3">
                                <b-form-group label="Código Interno">
                                    <ValidationProvider name="código interno" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="documento.codigo_interno"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col v-if="tipo_usuario < 3">
                                <b-form-group label="Clasificación">
                                    <ValidationProvider name="clasificación" rules="required|oneOf:1,2,3" v-slot="{ errors }">
                                        <b-form-select v-model="documento.clasificacion" class="mb-3">
                                            <option :value="0">Seleccionar una opción</option>
                                            <option :value="1">1 Estrella (s)</option>
                                            <option :value="2">2 Estrella (s)</option>
                                            <option :value="3">3 Estrella (s)</option>
                                        </b-form-select>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Categoría">
                                    <ValidationProvider name="categoria" rules="required:min_value:1" v-slot="{ errors }">
                                        <b-form-select v-model="documento.categoria_id" class="mb-3">
                                            <option :value="0">Seleccionar una opción</option>
                                            <option v-for="(categoria,index) in categorias" :key="index" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </b-form-select>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-form-group label="Documento">
                            <ValidationProvider name="documento" rules="required|ext:pdf,docx,xlsx,mp4,pptx,mp3" v-slot="{ errors, validate }">
                                <b-form-file id="documento" name="documento" accept=".pdf,.docx,.xlsx,.mp4,.pptx,.mp3" placeholder="Sin archivo" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group> 

                        <b-form-group label="Vista previa de uno">
                            <ValidationProvider name="vista previa" v-slot="{ errors, validate }">
                                <b-form-file id="documento_uno" name="documento_uno" accept="image/*" placeholder="Sin archivo" @change="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="Vista previa de dos">
                            <ValidationProvider name="vista previa" v-slot="{ errors, validate }">
                                <b-form-file id="documento_dos" name="documento_dos" accept="image/*" placeholder="Sin archivo" @change="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_documento.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_documento.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
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
        props: [
            'tipo', 'tipo_documento', 'titulo', 'tipo_usuario'
        ],
        data() {
            return {
                documento: {
                    id: 0,
                    titulo: '',
                    descripcion: '',
                    codigo: '',
                    codigo_interno: '',
                    documento_url: null,
                    valor: 0,
                    clasificacion: 0,
                    categoria_id: 0,
                    estado: this.tipo_documento
                },
                modal_documento: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'titulo', label: 'NOMBRE', sortable: true, class: 'text-left' },
                    { key: 'nombre_categoria', label: 'CATEGORÍA', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
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
                formData.append('codigo_interno', this.documento.codigo_interno);
                formData.append('documento_url', this.documento.documento_url);
                formData.append('valor', this.documento.valor);
                formData.append('clasificacion', this.documento.clasificacion);
                formData.append('categoria_id', this.documento.categoria_id);
                formData.append('estado', this.documento.estado);

                axios.post('documento/crear/actualizar',formData).then(function (response) {
                    me.listarDocumentos();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                    me.mensaje('success', mensaje);
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
                            me.mensaje('success', 'El Documento ha sido borrado!');
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
                                me.mensaje('success', 'El Documento se descargara pronto!');
                                
                                const link = document.createElement('a');
                                link.href = '/storage/' + response.data.documento.documento_url;
                                link.download = response.data.documento.titulo + '.' + response.data.documento.extension;
                                document.body.appendChild(link);
                                link.click();
                            } else {
                                me.mensaje(response.data.clase, response.data.mensaje);
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
                    me.documento.codigo_interno = data['codigo_interno'];
                    me.documento.valor = data['valor'];
                    me.documento.clasificacion = data['clasificacion'];
                    me.documento.categoria_id = data['categorias_documentos_id'];
                }

                this.$refs['modal_documento'].show();
            },
            limpiarDatosDocumentos(){
                this.documento.id = 0;
                this.documento.titulo = '';
                this.documento.descripcion = '';
                this.documento.codigo = '';
                this.documento.codigo_interno = '';
                this.documento.documento_url = null;
                this.documento.valor = 0;
                this.documento.clasificacion = 0;
                this.documento.categoria_id = 0;               
            }
        },
        mounted() {
            this.listarCategorias();
            this.listarDocumentos();
        }
    }
</script>