<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Tips</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un tip a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Tip</b-button>
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

                                <template v-slot:cell(acciones)="row">
                                    <b-button size="xs" variant="warning" title="Actualizar tip" @click="abrirModal(2, row.item)">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <b-button size="xs" variant="danger" title="Eliminar tip" @click="borrar(row.item.id, 1)">
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

            <ValidationObserver ref="observer_tip" v-slot="{ valid }">
                <b-modal ref="modal_tip" :title="modal_tip.titulo" no-close-on-backdrop>
                    <b-form>
                        <b-form-group label="Título">
                            <ValidationProvider name="tip" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                <b-form-input type="text" v-model="tip.nombre"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                        <b-form-group label="Descripción">
                            <ValidationProvider name="descripción" rules="required|min:20|max:200" v-slot="{ errors }">
                                <b-form-textarea v-model="tip.descripcion" placeholder="Escribe aquí ..." rows="3" max-rows="6"></b-form-textarea>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_tip.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_tip.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
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
                tip: {
                    id: 0,
                    nombre: '',
                    descripcion: ''
                },
                modal_tip: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                subtips: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
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
            listarTips (){
                let me=this;
                axios.get('/tips').then(function (response) {
                    me.items = response.data.tips;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                axios.post('tip/crear/actualizar',{
                    'tip_id': me.tip.id,
                    'nombre': me.tip.nombre,
                    'descripcion': me.tip.descripcion
                }).then(function (response) {
                    me.listarTips();
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
            borrar(id, accion){
                Swal.fire({
                    title: '¿Deseas borrar el tip?',
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
                        axios.post('tip/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarTips();

                            Vue.$toast.open({
		                        message: 'El tip ha sido quitado!',
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
                this.modal_tip.titulo = "";
                this.modal_tip.accion = 0;
                this.$refs['modal_tip'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosTip();

                if(accion == 1){
                    me.modal_tip.titulo = "Agregar Tip";
                    me.modal_tip.accion = 1;
                } else if(accion == 2){
                    me.modal_tip.titulo = "Modificar Tip";
                    me.modal_tip.accion = 2;

                    me.tip.id = data['id'];
                    me.tip.nombre = data['nombre'];
                    me.tip.descripcion = data['descripcion']
                }

                this.$refs['modal_tip'].show();
            },
            limpiarDatosTip(){
                this.tip.id = 0;
                this.tip.nombre = '';
                this.tip.descripcion = ''
            }
        },
        mounted() {
            this.listarTips();
        }
    }
</script>
