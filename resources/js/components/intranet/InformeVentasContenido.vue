<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5"  class="align-self-center"><h4 class="text-themecolor">Informe ventas de contenido</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right align-items-sm-">
                        <sociales></sociales>
                        <b-button @click="exportar_excel" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Descargar informe"><i class="fa fa-down"></i> Descargar informe</b-button>
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
                                <div class="table-responsive">
                                    <b-table
                                    id="tabla"
                                    name="tabla"
                                    show-empty
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

                                    <template v-slot:cell(rut_cliente)="data">
                                        {{ data.item.usuario ? data.item.usuario.run : 'Sin información' }}
                                    </template>

                                    <template v-slot:cell(nombre_cliente)="data">
                                        {{ data.item.usuario ? data.item.usuario.nombre : 'Sin información' }}
                                    </template>

                                    <template v-slot:cell(correo_cliente)="data">
                                        {{ data.item.usuario ? data.item.usuario.email : 'Sin información' }}
                                    </template>

                                    <template v-slot:cell(nivel_cliente)="data">
                                        {{ data.item.usuario.nivel_cliente }}
                                    </template>

                                    <template v-slot:cell(tipo_cliente)="data">
                                        {{ data.item.usuario ? data.item.usuario.persona : 'Sin información' }}
                                    </template>

                                    <template v-slot:cell(rubro_cliente)="data">
                                        {{ data.item.usuario.nombre_rubro }}
                                    </template>

                                    <template v-slot:cell(profesion_cliente)="data">
                                        {{ data.item.usuario.nombre_profesion }}
                                    </template>

                                    <template v-slot:cell(fecha_ultima_recarga)="data">
                                        {{ data.item.usuario.ultima_recarga }}
                                    </template>

                                    <template v-slot:cell(total_invertido)="data">
                                        {{ data.item.usuario.total_invertido | currency }}
                                    </template>

                                    <template v-slot:cell(total_bono_acumulado)="data">
                                        {{ data.item.usuario.total_bono_acumulado | currency }}
                                    </template>

                                    <template v-slot:cell(descripcion_administrador)="data">
                                        {{ data.item.usuario.descripcion_administrador != null && data.item.usuario.descripcion_administrador.length > 0 ? data.item.usuario.descripcion_administrador : 'Sin observación' }}
                                    </template>

                                </b-table>
                                </div>

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
                    { key: 'id', label: 'ID venta', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'rut_cliente', label: 'RUN o RUT', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre_cliente', label: 'Nombre del cliente', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'correo_cliente', label: 'Correo electrónico', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'tipo_cliente', label: 'Tipo de cliente', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nivel_cliente', label: 'Nivel del cliente', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'profesion_cliente', label: 'Profesión', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'rubro_cliente', label: 'Rubro', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'fecha_ultima_recarga', label: 'F. útima recarga', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'total_invertido', label: 'Recarga acumulada', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'total_bono_acumulado', label: 'Bono acumulado', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'descripcion_administrador', label: 'Observación', sortable: true, sortDirection: 'desc', class: 'text-center' },
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
            listar_informe (){
                let me=this;
                axios.get('/informe/venta/contenido').then(function (response) {
                    me.items = response.data.items;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            exportar_excel(){
                $("#tabla").tableExport({
                    fileName: 'Informe',
                    type: 'xls',
                    escape: false,
                    exportDataType: 'all',
                    refreshOptions: {
                        exportDataType: 'all'
                    }
                });
            },
            eliminar_elementos(){
                $('.sr-only').remove()
            }
        },
        mounted() {
            this.eliminar_elementos();
            this.listar_informe();
        }
    }
</script>