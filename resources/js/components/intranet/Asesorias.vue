<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Visitas a terreno</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
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
                                        {{ data.item.usuario.nombre }}
                                    </template>

                                    <template v-slot:cell(telefono)="data">
                                        +56 9 {{ data.item.usuario.telefono }}
                                    </template>

                                    <template v-slot:cell(email)="data">
                                        {{ data.item.usuario.email }}
                                    </template>

                                    <template v-slot:cell(observacion)="row">
                                        {{ row.item.observacion == null ? 'Sin observación' : row.item.observacion }}
                                    </template>

                                    <template v-slot:cell(estado)="row">
                                        <label v-if="row.item.estado == 0">Agendada</label>
                                        <label v-else-if="row.item.estado == 1">Realizada</label>
                                        <label v-else-if="row.item.estado == 2">Rechazada</label>
                                    </template>

                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="success" title="Marcar como realizada" @click="estado_asesoria(row.item.id, 1)">
                                            <i class="fa fa-check"></i>
                                        </b-button>

                                        <b-button size="xs" variant="danger" title="Rechazar" @click="estado_asesoria(row.item.id, 2)">
                                            <i class="fa fa-remove"></i>
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

            <ValidationObserver ref="observer_asesoria">
                <b-modal ref="modal_asesoria" :title="modal_asesoria.titulo" no-close-on-backdrop>
                    <b-form>
                        <b-form-group label="Observación">
                            <ValidationProvider name="observacion" rules="min:10" v-slot="{ errors }">
                                <b-form-textarea v-model="asesoria.observacion" rows="3" max-rows="6"></b-form-textarea>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button v-show="asesoria.estado== 1" size="md" variant="success" @click="crearOactualizar(1)"> Marcar como realizada </b-button>
                        <b-button v-show="asesoria.estado== 2" size="md" variant="warning" @click="crearOactualizar(2)"> Rechazar </b-button>
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
                asesoria: {
                    id: 0,
                    observacion: '',
                    estado: 0
                },
                modal_asesoria: {
                    titulo: ''
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'usuario', label: 'Usuario', sortable: true, class: 'text-left' },
                    { key: 'telefono', label: 'Teléfono', sortable: true, class: 'text-left' },
                    { key: 'email', label: 'Email', sortable: true, class: 'text-left' },
                    { key: 'observacion', label: 'Observación', sortable: true, class: 'text-left' },
                    { key: 'estado', label: 'Estado', sortable: true, class: 'text-left' },
                    { key: 'created_at', label: 'Fecha', sortable: true, class: 'text-left' },
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
            listarAsesorias (){
                let me=this;
                axios.get('/asesorias/1').then(function (response) {
                    me.items = response.data.asesorias;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            estado_asesoria(id, accion){
                this.limpiar_modal_asesoria();

                this.modal_asesoria.titulo = accion == 1 ? 'Marcar asesoría como realizada' : 'Rechazar asesoría';
                this.asesoria.id = id;
                this.asesoria.estado = accion;

                this.$refs['modal_asesoria'].show();
            },
            limpiar_modal_asesoria(){
                this.asesoria.id = 0;
                this.asesoria.observacion = '';
                this.asesoria.estado = 0;
            },
            crearOactualizar(){
                let me = this;

                axios.post('asesoria/estado',{
                    'asesoria_id': me.asesoria.id,
                    'observacion': me.asesoria.observacion,
                    'estado': me.asesoria.estado
                }).then(function (response) {
                    me.listarAsesorias();
                    me.cerrarModal();
                    var mensaje = me.asesoria.estado == 1 ? 'Asesoría marcada como realizada' : 'Asesoría rechazada';

					Vue.$toast.open({
                        message: mensaje,
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            },
            cerrarModal(){
                this.modal_asesoria.titulo = "";
                this.$refs['modal_asesoria'].hide();
            }
        },
        mounted() {
            this.listarAsesorias();
        }
    }
</script>
