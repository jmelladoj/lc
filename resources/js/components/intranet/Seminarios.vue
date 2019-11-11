<template>
    <div class="page-wrapper">
        <b-container fluid>
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Seminarios</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button v-if="tipo_usuario < 3" @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un seminario"><i class="fa fa-plus-circle"></i> Agregar Seminario</b-button>
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

                                <template v-slot:cell(imagen)="data">
                                    <b-img :src="'storage/' + data.item.url_imagen" fluid center alt="Seminario" class="imagen"></b-img>
                                </template>

                                <template v-slot:cell(acciones)="row">
                                    <b-button v-show="tipo_usuario == 3" size="xs" variant="success" title="Participar" @click="participar(row.item.id)">
                                        <i class="fa fa-plus"></i>
                                    </b-button>

                                    <b-button v-show="tipo_usuario < 3" size="xs" variant="success" title="Ver participantes" @click="abrirModalParticipantes(row.item)">
                                        <i class="fa fa-users"></i>
                                    </b-button>

                                    <b-button v-show="tipo_usuario < 3" size="xs" variant="warning" title="Actualizar seminario" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <b-button v-show="tipo_usuario < 3" size="xs" variant="danger" title="Eliminar seminario" @click="borrar(row.item.id)">
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
            
            <ValidationObserver ref="observer_seminario" v-slot="{ valid }">
                <b-modal ref="modal_seminario" :title="modal_seminario.titulo" size="md" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-row>
                            <b-col>
                                <b-form-group label="Título de Seminario">
                                    <ValidationProvider name="título" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="seminario.titulo"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Fecha de Seminario">
                                    <ValidationProvider name="fecha" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-input type="date" v-model="seminario.fecha"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col> 
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group label="Valor de inscripción">
                                    <ValidationProvider name="valor" rules="required|numeric|min_value:0" v-slot="{ errors }">
                                        <b-form-input type="number" v-model="seminario.valor"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Capacidad de seminario">
                                    <ValidationProvider name="capacidad" rules="required|numeric|min_value:0" v-slot="{ errors }">
                                        <b-form-input type="number" v-model="seminario.capacidad"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col> 
                        </b-row>

                        <b-form-group label="Descripción de seminario">
                            <ValidationProvider name="descripción" rules="required|min:10" v-slot="{ errors }">
                                <b-form-textarea v-model="seminario.descripcion" placeholder="Escribe aquí ..." rows="3" max-rows="6"></b-form-textarea>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        
                        <b-form-group label="Tipo de persona">
                            <ValidationProvider name="tipo de persona" rules="required|oneOf:1,2,3" v-slot="{ errors }">
                                <b-form-select v-model="seminario.tipo_persona">
                                    <option :value="0">Selecciona una opción</option>
                                    <option :value="1">Persona</option>
                                    <option :value="2">Pyme</option>
                                    <option :value="3">Estudiante</option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group label="Imagen (Rec. 1920px ancho X 1280px alto | JPG, JPEG y PNG)">
                            <ValidationProvider name="imagen" rules="required|image" v-slot="{ errors, validate }">
                                <b-img  :src="seminario.url_imagen"  id="img_seminario" center name="img_seminario" class="imagen"></b-img>
                                <b-form-file id="imagen_seminario" name="imagen_seminario" accept="image/*" placeholder="Sin archivo" @change="mostrarFoto($event)" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_seminario.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_seminario.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
                        <b-button size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>

            <b-modal ref="modal_participantes" :title="modal_participantes.titulo" size="md" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-form-group>
                            <b-table show-empty responsive striped borderless outlined small hover
                                :items="participantes" 
                                :fields="campos">

                                <template slot="empty">
                                    <center><h5>No hay registros para mostrar.</h5></center>
                                </template>

                                <template v-slot:cell(index)="data">
                                    {{ data.index + 1 }}
                                </template>

                                <template v-slot:cell(usuario)="data">
                                    {{ data.item.usuario.nombre }}
                                </template>

                                <template v-slot:cell(telefono)="data">
                                    +56 9 {{ data.item.usuario.telefono }}
                                </template>

                                <template v-slot:cell(email)="data">
                                    {{ data.item.usuario.email }}
                                </template>

                                <template v-slot:cell(imagen)="data">
                                    <b-img :src="'storage/' + data.item.url_imagen" fluid center alt="Seminario" class="imagen"></b-img>
                                </template>

                            </b-table>
                        </b-form-group>

                    </b-form>

                    <template slot="modal-footer">
                        <b-button size="md" variant="danger" @click="cerrarModalParticipantes()"> Cerrar </b-button>
                    </template>
                </b-modal>

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
                seminario: {
                    id: 0,                  
                    titulo: '',
                    fecha: '',
                    valor: 0,
                    capacidad: 0,
                    descripcion: '',
                    tipo_persona: 0,
                    url_imagen: ''
                },
                modal_seminario: {
                    titulo: '',
                    accion: 0
                },
                modal_participantes: {
                    titulo: ''
                },
                participantes: [],
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'titulo', label: 'NOMBRE', sortable: true, class: 'text-left' },
                    { key: 'fecha', label: 'FECHA', sortable: true, class: 'text-center' },
                    { key: 'capacidad', label: 'CAPACIDAD', sortable: true, class: 'text-center' },
                    { key: 'participantes', label: 'PARTICIPANTES', sortable: true, class: 'text-center' },
                    { key: 'imagen', label: 'IMAGEN', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
                ],
                campos: [
                    { key: 'index', label: '#', class: 'text-center' },
                    { key: 'usuario', label: 'NOMBRE', class: 'text-left'},
                    { key: 'telefono', label: 'TELÉFONO', class: 'text-center'},
                    { key: 'email', label: 'EMAIL', class: 'text-left'}
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
                    $('#imagen_seminario').attr('src', e.target.result);
                }

                if(e.target.files[0]){
                    reader.readAsDataURL(e.target.files[0]);
                    this.seminario.url_imagen = URL.createObjectURL(e.target.files[0]);
                }
            },
            listarSeminarios (){
                let me = this;
                axios.get('/seminarios/' + this.tipo).then(function (response) {
                    me.items = response.data.seminarios;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarParticipantes (){
                let me = this;
                me.participantes = [];

                axios.get('/seminario/participantes/' + me.seminario.id).then(function (response) {
                    me.participantes = response.data.participantes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                let formData = new FormData();
                let imagen_seminario = document.querySelector('#imagen_seminario');
                formData.append('imagen_seminario', imagen_seminario.files[0]);
                
                formData.append('seminario_id', this.seminario.id);
                formData.append('titulo', this.seminario.titulo);
                formData.append('fecha', this.seminario.fecha);
                formData.append('valor', this.seminario.valor);
                formData.append('capacidad', this.seminario.capacidad);
                formData.append('descripcion', this.seminario.descripcion);
                formData.append('tipo_persona', this.seminario.tipo_persona);

                axios.post('seminario/crear/actualizar',formData).then(function (response) {
                    me.listarSeminarios();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                    me.mensaje('success', mensaje);
                }).catch(function (error) {
                    console.error(error);
                });
            },
            participar(id){
                Swal.fire({
                    title: '¿Deseas participar en el Seminario?',
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
                        axios.post('/seminario/participar',{
                            'id': id
                        }).then(function (response) {
                            me.listarSeminarios();
                            me.mensaje(response.data.clase, response.data.mensaje);
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el Seminario?',
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
                        axios.post('/seminario/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarSeminarios();
                            me.mensaje('success', 'La Seminario ha sido borrada!');
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
                this.modal_seminario.titulo = "";
                this.modal_seminario.accion = 0;
                this.$refs['modal_seminario'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosSeminario();

                if(accion == 1){
                    me.modal_seminario.titulo = "Agregar Seminario";
                    me.modal_seminario.accion = 1;
                } else if(accion == 2){
                    me.modal_seminario.titulo = "Modificar Seminario";
                    me.modal_seminario.accion = 2;

                    me.seminario.id = data['id'];
                    me.seminario.titulo = data['titulo'];
                    me.seminario.fecha = data['fecha'];
                    me.seminario.valor = data['valor'];
                    me.seminario.capacidad = data['capacidad'];
                    me.seminario.descripcion = data['descripcion'];
                    me.seminario.categoria_usuario = data['categoria_usuario'];
                    me.seminario.tipo_persona = data['tipo_persona'];
                }

                this.$refs['modal_seminario'].show();
            },
            abrirModalParticipantes(data = []){
                this.modal_participantes.titulo = "Seminario " + data['titulo'];
                this.seminario.id = data['id'];
                this.listarParticipantes();
                this.$refs['modal_participantes'].show();
            },
            cerrarModalParticipantes(){
                this.modal_participantes.titulo = "";
                this.seminario.id = 0;
                this.$refs['modal_participantes'].hide();
            },
            limpiarDatosSeminario(){
                this.seminario.id = 0;               
                this.seminario.titulo = '';
                this.seminario.fecha = '';
                this.seminario.valor = 0;
                this.seminario.capacidad = 0;
                this.seminario.descripcion = '';
                this.seminario.categoria_usuario = 0;
                this.seminario.tipo_persona = 0;
                this.seminario.url_imagen = '';
            }
        },
        mounted() {
            this.listarSeminarios();
        }
    }
</script>