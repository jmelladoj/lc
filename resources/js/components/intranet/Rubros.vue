<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Rubros</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agregar un rubro"><i class="fa fa-plus-circle"></i> Agregar Rubro</b-button>
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
                                    <b-button size="xs" variant="warning" title="Actualizar Rubro" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <template>
                                        <b-button v-if="row.item.deleted_at" size="xs" variant="warning" title="Restaurar Rubro" @click="borrarOrestaurar(row.item.id, 2)">
                                            <i class="fa fa-undo"></i>
                                        </b-button>

                                        <b-button v-else size="xs" variant="danger" title="Eliminar Rubro" @click="borrarOrestaurar(row.item.id, 1)">
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
            
            <ValidationObserver ref="observer_rubro" v-slot="{ valid }">
                <b-modal ref="modal_rubro" :title="modal_rubro.titulo" no-close-on-backdrop>
                    <b-form>
                        <b-form-group label="Nombre de rubro">
                            <ValidationProvider name="rubro" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                <b-form-input type="text" v-model="rubro.nombre"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_rubro.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_rubro.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
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
                rubro: {
                    id: 0,
                    nombre: '',
                    tipo_persona: 0
                },
                modal_rubro: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                subrubros: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', sortable: true, class: 'text-left' },
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
                    position: 'bottom-end',
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
            listarRubros (){
                let me=this;
                axios.get('/rubros/1').then(function (response) {
                    me.items = response.data.rubros;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                axios.post('/rubro/crear/actualizar',{
                    'rubro_id': me.rubro.id,
                    'nombre': me.rubro.nombre
                }).then(function (response) {
                    me.listarRubros();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                    me.mensaje('success', mensaje);
                }).catch(function (error) {
                    console.error(error);
                });
            },
            borrarOrestaurar(id, accion){
                var mensaje = accion == 2 ? '¿Deseas restaurar el Rubro' : '¿Deseas borrar el Rubro';
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

                        var url = accion == 2 ? '/rubro/restaurar' : 'rubro/eliminar';
                        axios.post(url,{
                            'id': id
                        }).then(function (response) {
                            var mensaje = accion == 2 ? 'El Rubro ha sido restaurado!' : 'El Rubro ha sido quitado!';
                            me.listarRubros();
                            me.mensaje('success', mensaje);
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
                this.modal_rubro.titulo = "";
                this.modal_rubro.accion = 0;
                this.$refs['modal_rubro'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosrubro();

                if(accion == 1){
                    me.modal_rubro.titulo = "Agregar Rubro";
                    me.modal_rubro.accion = 1;
                } else if(accion == 2){
                    me.modal_rubro.titulo = "Modificar Rubro";
                    me.modal_rubro.accion = 2;

                    me.rubro.id = data['id'];
                    me.rubro.nombre = data['nombre'];
                }

                this.$refs['modal_rubro'].show();
            },
            limpiarDatosrubro(){
                this.rubro.id = 0;
                this.rubro.nombre = '';
            }
        },
        mounted() {
            this.listarRubros();
        }
    }
</script>