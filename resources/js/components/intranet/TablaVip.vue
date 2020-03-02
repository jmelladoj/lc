<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Tabla VIP</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="$root.menu = 5" class="btn btn-success d-lg-block m-l-15" v-b-tooltip title="Agrega un usuario a la plataforma"><i class="fa fa-arrow-left"></i> Volver a usuarios</b-button>
                    </div>
                </b-col>
            </b-row>

            <b-card>
                <b-row>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Cliente">
                            <b-form-input v-model="tabla.empresa" type="text" readonly="" placeholder="Pyme"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Categoría">
                            <ValidationProvider name="posición" rules="required|numeric|between:0,10" v-slot="{ errors }">
                                <b-form-select v-model="tabla.posicion" @change="actualizar_usuario_tabla">
                                    <option value="0">Estrellas</option>
                                    <option value="1">1 Estrella(s)</option>
                                    <option value="2">2 Estrella(s)</option>
                                    <option value="3">3 Estrella(s)</option>
                                    <option value="4">4 Estrella(s)</option>
                                    <option value="5">5 Estrella(s)</option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="N° likes">
                            <ValidationProvider name="likes" rules="required|numeric|min:0" v-slot="{ errors }">
                                <b-form-input type="number" v-model="tabla.likes" placeholder="Likes" @keyup="actualizar_usuario_tabla"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="N° dislikes">
                            <ValidationProvider name="dislikes" rules="required|numeric|min:0" v-slot="{ errors }">
                                <b-form-input type="number" v-model="tabla.dislikes" placeholder="Dislikes" @keyup="actualizar_usuario_tabla"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-card>

            <b-row v-show="tabla.usuario_id > 0">
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid>
                                <b-row class="mb-2">
                                    <b-col>
                                        <b-button @click="abrir_modal_comentarios(1)" class="btn btn-success pull-right" v-b-tooltip.hover title="Agrega una slider a la plataforma"><i class="fa fa-plus-circle"></i> Agregar comentario</b-button>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter_pyme" placeholder="Escribe para buscar" />
                                            <b-input-group-append>
                                            <b-button :disabled="!filter_pyme" @click="filter_pyme = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Ordenar" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortBy_pyme" :options="sortOptions_pyme">
                                            <option slot="first" :value="null">-- nada --</option>
                                            </b-form-select>
                                            <b-form-select :disabled="!sortBy_pyme" v-model="sortDesc_pyme" slot="append">
                                            <option :value="false">Asc</option> <option :value="true">Desc</option>
                                            </b-form-select>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Dirección" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortDirection_pyme" slot="append">
                                            <option value="asc">Asc</option> <option value="desc">Desc</option>
                                            <option value="last">Último</option>
                                            </b-form-select>
                                        </b-input-group>
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
                                    :items="items_pyme"
                                    :fields="fields_pyme"
                                    :current-page="currentPage_pyme"
                                    :per-page="perPage_pyme"
                                    :filter="filter_pyme"
                                    :sort-by.sync="sortBy_pyme"
                                    :sort-desc.sync="sortDesc_pyme"
                                    :sort-direction="sortDirection_pyme"
                                    @filtered="onFiltered_pyme">

                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>

                                    <template slot="empty">
                                        <center><h5>No hay registros para mostrar.</h5></center>
                                    </template>

                                    <template slot="emptyfiltered">
                                        <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                    </template>

                                    <template v-slot:cell(tipo_votacion)="row">
                                        <label v-text="row.item.tipo_votacion == 1 ? 'Positivo' : 'Negativo'"></label>
                                    </template>

                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="warning" title="Actualizar comentario" @click="abrir_modal_comentarios(2, row.item)">
                                            <i class="fa fa-pencil"></i>
                                        </b-button>

                                        <b-button size="xs" variant="danger" title="Eliminar comentario" @click="borrar(row.item.id)">
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

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid>

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
                                        <b-form-group label-cols-sm="3" label="Dirección" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortDirection" slot="append">
                                            <option value="asc">Asc</option> <option value="desc">Desc</option>
                                            <option value="last">Último</option>
                                            </b-form-select>
                                        </b-input-group>
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
                                    @filtered="onFiltered">

                                    <template slot="empty">
                                        <center><h5>No hay registros para mostrar.</h5></center>
                                    </template>

                                    <template slot="emptyfiltered">
                                        <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                    </template>

                                    <template v-slot:cell(nombre)="row">
                                        <label  @click="actualizar_tabla(row.item)" v-text="row.item.nombre"></label>
                                    </template>

                                    <template v-slot:cell(tipo)="data">
                                        <label v-if="data.item.tipo_persona == 1"> Persona </label>
                                        <label v-else-if="data.item.tipo_persona == 2"> Pyme </label>
                                        <label v-else-if="data.item.tipo_persona == 3"> Estudiante </label>
                                    </template>

                                    <template v-slot:cell(like_porcentaje_admin)="row">
                                        {{ row.item.like_porcentaje_admin }} %
                                    </template>

                                    <template v-slot:cell(porcentaje_dislike_vip)="row">
                                        {{ row.item.like_porcentaje_admin > 0 ? 100 - row.item.like_porcentaje_admin : 0}} %
                                    </template>


                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="warning" title="Actualizar usuario" @click="actualizar_tabla(row.item)">
                                            <i class="fa fa-pencil"></i>
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

            <ValidationObserver ref="observer_comentario" v-slot="{ valid }">
                <b-modal ref="modal_comentario" :title="modal_comentario.titulo" size="lg" no-close-on-backdrop>
                    <b-form>
                        <b-form-group label="Autor de comentario">
                            <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                <b-form-input type="text" v-model="comentario.autor"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group>
                            <ValidationProvider name="Tipo de comentario" rules="required" v-slot="{ errors }">
                                <b-form-select v-model="comentario.tipo_votacion" class="mb-3">
                                    <option :value="1" selected>Positivo</option>
                                    <option :value="2" selected>Negativo</option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>

                        <b-form-group  label="Detalle">
                            <ValidationProvider name="detalle de software" rules="required|min:20|max:200" v-slot="{ errors }">
                                <b-form-textarea v-model="comentario.detalle" placeholder="Escribe aquí ..." rows="3" max-rows="6"></b-form-textarea>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_comentario.accion == 1" size="md" variant="success" @click="crear_actualizar_comentario(1)"> Guardar </b-button>
                        <b-button v-show="modal_comentario.accion == 2" size="md" variant="warning" @click="crear_actualizar_comentario(2)"> Actualizar </b-button>
                        <b-button size="md" variant="danger" @click="cerrar_modal()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>
        </b-container>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                items: [],
                items_pyme: [],
                comentario: {
                    id: 0,
                    autor: '',
                    tipo_votacion: 1,
                    detalle: ''
                },
                modal_comentario: {
                    titulo: '',
                    accion: 0
                },
                tabla: {
                    usuario_id: 0,
                    empresa: null,
                    posicion: 0,
                    likes: null,
                    dislikes: null
                },
                fields: [
                    { key: 'posicion', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Pyme', sortable: true, class: 'text-left' },
                    { key: 'nombreComuna', label: 'Comuna', sortable: true, class: 'text-left' },
                    { key: 'nombreRubro', label: 'Rubro', sortable: true, class: 'text-left' },
                    { key: 'like_porcentaje_admin', label: 'Likes', sortable: true, class: 'text-center' },
                    { key: 'porcentaje_dislike_vip', label: 'Dislikes', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                fields_pyme: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre_usuario', label: 'Autor', sortable: true, class: 'text-left' },
                    { key: 'tipo_votacion', label: 'Tipo comentario', sortable: true, class: 'text-left' },
                    { key: 'descripcion', label: 'Comentario', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                currentPage_pyme: 1,
                perPage_pyme: 10,
                totalRows_pyme: 0,
                pageOptions_pyme: [10, 25, 50, 100],
                sortBy_pyme: null,
                sortDesc_pyme: false,
                sortDirection_pyme: 'asc',
                filter_pyme: null,
            }
        },
        computed: {
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            },
            sortOptions_pyme() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods: {
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            onFiltered_pyme(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listar_valoraciones(){
                let me=this;
                axios.get('/usuario/valoraciones/' + this.tabla.usuario_id).then(function (response) {
                    me.items_pyme = response.data.valoraciones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarUsuariosTablaVip(){
                let me=this;
                axios.get('/usuarios/tabla/vip').then(function (response) {
                    me.items = response.data.usuarios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizar_tabla(data = []){
                this.tabla.usuario_id = data.id
                this.tabla.empresa = data.nombre
                this.tabla.posicion = data.posicion
                this.tabla.likes = data.likes
                this.tabla.dislikes = data.dislikes

                this.listar_valoraciones()
            },
            actualizar_usuario_tabla(){
                let me = this;

                axios.post('/usuario/actualizar/tabla/vip',{
                    'id': me.tabla.usuario_id,
                    'posicion': me.tabla.posicion,
                    'likes': me.tabla.likes,
                    'dislikes': me.tabla.dislikes
                }).then(function (response) {
                    me.listarUsuariosTablaVip();

                    Vue.$toast.open({
                        message: 'Cambio guardado exitosamente!',
                        type: 'success',
                        duration: 2000
                    });


                }).catch(function (error) {
                    console.error(error);
                });
            },
            abrir_modal_comentarios(accion, data = []){
                let me = this;
                this.limpiar_datos_comentario();

                if(accion == 1){
                    me.modal_comentario.titulo = "Agregar comentario";
                    me.modal_comentario.accion = 1;
                } else if(accion == 2){
                    me.modal_comentario.titulo = "Modificar comentario";
                    me.modal_comentario.accion = 2;

                    me.comentario.id = data.id;
                    me.comentario.autor = data.nombre_usuario;
                    me.comentario.tipo_votacion = data.tipo_votacion;
                    me.comentario.detalle = data.descripcion;
                }

                this.$refs['modal_comentario'].show();
            },
            cerrar_modal(){
                this.modal_comentario.titulo = "";
                this.modal_comentario.accion = 0;
                this.$refs['modal_comentario'].hide();
            },
            limpiar_datos_comentario(){
                this.comentario.id = 0
                this.comentario.autor = ''
                this.comentario.tipo_votacion = 1
                this.comentario.detalle = ''
            },
            crear_actualizar_comentario(accion){
                let me = this;

                axios.post('/valorar/pyme',{
                    'id': me.comentario.id,
                    'autor': me.comentario.autor,
                    'detalle': me.comentario.detalle,
                    'tipo_votacion': me.comentario.tipo_votacion
                }).then(function (response) {
                    me.listar_valoraciones();
                    me.cerrar_modal();
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
            borrar(id, accion){
                var mensaje = '¿Deseas borrar el comentario?';
                Swal.fire({
                    title: mensaje,
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

                        axios.post('/valorar/borrar',{
                            'id': id
                        }).then(function (response) {
                            var mensaje = 'Registro borrado exitosamente';
                            me.listar_valoraciones();

							Vue.$toast.open({
		                        message: mensaje,
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
        },
        mounted(){
            this.listarUsuariosTablaVip()
        }
    }
</script>
