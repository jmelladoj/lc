<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Profesión u Oficio</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agregar una profesión u oficio"><i class="fa fa-plus-circle"></i> Agregar Profesión u Oficio</b-button>
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

                                <template v-slot:cell(usuario)="data">
                                    <label v-if="data.item.tipo_persona == 1"> Persona </label>
                                    <label v-else-if="data.item.tipo_persona == 2"> Pyme </label>
                                    <label v-else-if="data.item.tipo_persona == 3"> Estudiante </label>
                                </template>

                                <template v-slot:cell(acciones)="row">
                                    <b-button size="xs" variant="warning" title="Actualizar profesión u oficio" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <template>
                                        <b-button v-if="row.item.deleted_at" size="xs" variant="warning" title="Restaurar profesión u oficio" @click="borrarOrestaurar(row.item.id, 2)">
                                            <i class="fa fa-undo"></i>
                                        </b-button>

                                        <b-button v-else size="xs" variant="danger" title="Eliminar profesión u oficio" @click="borrarOrestaurar(row.item.id, 1)">
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

            <ValidationObserver ref="observer_profesion_oficio" v-slot="{ valid }">
                <b-modal ref="modal_profesion_oficio" :title="modal_profesion_oficio.titulo" no-close-on-backdrop>
                    <b-form>
                        <b-form-group label="Nombre de profesión u oficio">
                            <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                <b-form-input type="text" v-model="profesion_oficio.nombre"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                        <b-form-group label="Tipo de persona">
                            <ValidationProvider name="tipo de persona" rules="oneOf:1,2,3" v-slot="{ errors }">
                                <b-form-select v-model="profesion_oficio.tipo_persona">
                                    <option :value="0">Selecciona una opción ...</option>
                                    <option :value="1">Persona</option>
                                    <option :value="2">Pyme</option>
                                    <option :value="3">Estudiante</option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_profesion_oficio.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_profesion_oficio.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
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
                profesion_oficio: {
                    id: 0,
                    nombre: '',
                    tipo_persona: 0
                },
                modal_profesion_oficio: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'usuario', label: 'Tipo de usuario', sortable: true, class: 'text-left' },
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
            listarProfesionesOficios (){
                let me=this;
                axios.get('/profesiones/oficios/1').then(function (response) {
                    me.items = response.data.profesiones;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                axios.post('/profesion/oficio/crear/actualizar',{
                    'profesion_oficio_id': me.profesion_oficio.id,
                    'nombre': me.profesion_oficio.nombre,
                    'tipo_persona': me.profesion_oficio.tipo_persona
                }).then(function (response) {
                    me.listarProfesionesOficios();
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
            borrarOrestaurar(id, accion){
                var mensaje = accion == 2 ? '¿Deseas restaurar el registro' : '¿Deseas borrar el registro';
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

                        var url = accion == 2 ? '/profesion/oficio/restaurar' : '/profesion/oficio/eliminar';
                        axios.post(url,{
                            'id': id
                        }).then(function (response) {
                            var mensaje = accion == 2 ? 'El registro ha sido restaurado!' : 'El registro ha sido quitado!';
                            me.listarProfesionesOficios();

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
            cerrarModal(){
                this.modal_profesion_oficio.titulo = "";
                this.modal_profesion_oficio.accion = 0;
                this.$refs['modal_profesion_oficio'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosProfesionOficio();

                if(accion == 1){
                    me.modal_profesion_oficio.titulo = "Agregar Profesión u Oficio";
                    me.modal_profesion_oficio.accion = 1;
                } else if(accion == 2){
                    me.modal_profesion_oficio.titulo = "Modificar Profesión u Oficio";
                    me.modal_profesion_oficio.accion = 2;

                    me.profesion_oficio.id = data['id'];
                    me.profesion_oficio.nombre = data['nombre'];
                    me.profesion_oficio.tipo_persona = data['tipo_persona'];
                }

                this.$refs['modal_profesion_oficio'].show();
            },
            limpiarDatosProfesionOficio(){
                this.profesion_oficio.id = 0;
                this.profesion_oficio.nombre = '';
                this.profesion_oficio.tipo_persona = 0;
            }
        },
        mounted() {
            this.listarProfesionesOficios();
        }
    }
</script>
