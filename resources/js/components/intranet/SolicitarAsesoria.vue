<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Visitas a terreno</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="solicitarAsesoria" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Solicitar asesoría"><i class="fa fa-plus-circle"></i> Solicitar asesoría</b-button>
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

                            <template v-slot:cell(observacion)="row">
                                {{ row.item.observacion == null ? 'Sin observación' : row.item.observacion }}
                            </template>

                            <template v-slot:cell(estado)="row">
                                <label v-if="row.item.estado == 0">Agendada</label>
                                <label v-else-if="row.item.estado == 1">Realizada</label>
                                <label v-else-if="row.item.estado == 2">Rechazada</label>
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

    </b-container>

    </div>
</template>

<script>
    const items = [];

    export default {
        data() {
            return {
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'created_at', label: 'Fecha solicitud', sortable: true, class: 'text-center' },
                    { key: 'observacion', label: 'Observación', sortable: true, class: 'text-center' },
                    { key: 'estado', label: 'Estado', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                solicitud: {
                    descripcion: '',
                    pago: 0,
                    plazo: 0
                }
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
                axios.get('/asesorias/2').then(function (response) {
                    me.items = response.data.asesorias;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            solicitarAsesoria(){
                Swal.fire({
                    title: '¿Deseas solicitar una asesoría?',
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
                        axios.post('/solicitar/asesoria').then(function (response) {
                            me.listarAsesorias()
                        	Vue.$toast.open({
		                        message: 'Solicitud enviada exitosamente',
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            }
        },
        mounted() {
            this.listarAsesorias();
        }
    }
</script>
