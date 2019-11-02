<template>
    <div class="page-wrapper">
        <b-container fluid>
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Categorías Clientes</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega una categoría a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Categoría</b-button>
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
                                    @filtered="onFiltered">

                                <template slot="empty">
                                    <center><h5>No hay registros para mostrar.</h5></center>
                                </template>

                                <template slot="emptyfiltered">
                                    <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                </template>

                                <template v-slot:cell(index)="data">
                                    {{ data.index + 1 }}
                                </template>

                                <template v-slot:cell(acciones)="row">
                                    <b-button size="xs" variant="success" title="Agregar subcategorías a la categoría" @click="abrirModalCategoria(row.item)">
                                        <i class="fa fa-plus"></i>
                                    </b-button>

                                    <b-button size="xs" variant="warning" title="Actualizar información de categoría" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <template>
                                        <b-button v-if="row.item.deleted_at" size="xs" variant="warning" title="Restaurar categoría" @click="borrarOrestaurar(row.item.id, 2)">
                                            <i class="fa fa-undo"></i>
                                        </b-button>

                                        <b-button v-else size="xs" variant="danger" title="Eliminar categoría" @click="borrarOrestaurar(row.item.id, 1)">
                                            <i class="fa fa-trash"></i>
                                        </b-button>
                                    </template>
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
            
            <ValidationObserver ref="observer_categoria" v-slot="{ valid }">
                <b-modal ref="modal_categoria" :title="modal_categoria.titulo" size="lg" no-close-on-backdrop>
                    <b-form>
                        <b-row>
                            <b-col>
                                <b-form-group label="Nombre de Categoría">
                                    <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="categoria.nombre"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Nivel de Categoría">
                                    <ValidationProvider name="nivel" rules="required|min:3" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="categoria.nivel"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group label="Gasta inicio">
                                    <ValidationProvider name="gasto inicio" rules="required|min_value:0|numeric" v-slot="{ errors }">
                                        <b-form-input type="numeric" v-model="categoria.gasto_inicio"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Gasto fin">
                                    <ValidationProvider name="gasto fin" rules="required|min_value:0|numeric" v-slot="{ errors }">
                                        <b-form-input type="numeric" v-model="categoria.gasto_fin"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group label="Color">
                                    <ValidationProvider name="color" rules="required|min:1" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="categoria.color"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group label="Bonificación">
                                    <ValidationProvider name="bonificación" rules="required|min_value:1|numeric" v-slot="{ errors }">
                                        <b-form-input type="numeric" v-model="categoria.bonificacion"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_categoria.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_categoria.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
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
                categoria: {
                    id: 0,
                    nombre: '',
                    nivel: '',
                    gasto_inicio: 0,
                    gasto_fin: 0,
                    color: '',
                    bonificacion: 0
                },
                modal_categoria: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                subcategorias: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
                ],
                campos: [
                    { key: 'index', label: '#', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', class: 'text-left'},
                    { key: 'acciones', label: 'ACCIONES', class: 'text-center'}
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
            listarCategorias (){
                let me=this;
                axios.get('/categorias/usuario').then(function (response) {
                    me.items = response.data.categorias;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                axios.post('/categoria/usuario/crear/actualizar',{
                    'categoria_id': me.categoria.id,
                    'nombre': me.categoria.nombre,
                    'nivel': me.categoria.nivel,
                    'gasto_inicio': me.categoria.gasto_inicio,
                    'gasto_fin': me.categoria.gasto_fin,
                    'color': me.categoria.color,
                    'bonificacion': me.categoria.bonificacion
                }).then(function (response) {
                    me.listarCategorias();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                    me.mensaje('success', mensaje);
                }).catch(function (error) {
                    console.error(error);
                });
            },
            borrarOrestaurar(id, accion){
                var mensaje = accion == 2 ? '¿Deseas restaurar la Categoría?' : '¿Deseas borrar la Categoría?';
                Swal.fire({
                    title: mensaje,
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

                        var url = accion == 2 ? '/categoria/usuario/restaurar' : 'categoria/usuario/eliminar';
                        axios.post(url,{
                            'id': id
                        }).then(function (response) {
                            var mensaje = accion == 2 ? 'La Categoría ha sido restaurada!' : 'La Categoría ha sido quitada!';
                            me.listarCategorias();
                            me.mensaje('success', mensaje);
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
                this.modal_categoria.titulo = "";
                this.modal_categoria.accion = 0;
                this.$refs['modal_categoria'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosCategoria();

                if(accion == 1){
                    me.modal_categoria.titulo = "Agregar Categoría";
                    me.modal_categoria.accion = 1;
                } else if(accion == 2){
                    me.modal_categoria.titulo = "Modificar Categoría";
                    me.modal_categoria.accion = 2;

                    me.categoria.id = data['id'];
                    me.categoria.nombre = data['nombre'];
                }

                this.$refs['modal_categoria'].show();
            },
            limpiarDatosCategoria(){
                this.categoria.id = 0;
                this.categoria.nombre = '';
            }
        },
        mounted() {
            this.listarCategorias();
        }
    }
</script>