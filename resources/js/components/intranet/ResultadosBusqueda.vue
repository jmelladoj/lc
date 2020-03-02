<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Resultados</h4></b-col>
                <b-col xs="12" sm="12" md="7">
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
                                        <center>
                                            <h5>Lo sentimos, no hay coincidencias.</h5><br>
                                            <b-button variant="success" size="md" @click="$root.menu = 2">Solicita un documento a pedido</b-button>
                                        </center>
                                    </template>

                                    <template slot="emptyfiltered">
                                        <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                    </template>

                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>

                                    <template v-slot:cell(acciones)="row">
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
                                        <b-pagination
                                            :total-rows="totalRows"
                                            :per-page="perPage"
                                            v-model="currentPage"
                                            class="my-3"
                                            align="fill"
                                        />
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
                items: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Título', sortable: true, class: 'text-left' },
                    { key: 'autor', label: 'Autor', sortable: true, class: 'text-left' },
                    { key: 'valor', label: 'Precio', sortable: true, class: 'text-left' },
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
            listar_documentos (busqueda){
                let me=this;
                axios.get('/documentos/busqueda/' + busqueda).then(function (response) {
                    me.items = response.data.categorias;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            Evento.$on('listar_documentos', (busqueda) => {
                this.listar_documentos(busqueda);
            })
        }
    }
</script>


<style>
    .swal2-styled:focus {
        outline: 0;
        box-shadow: none;
    }
</style>
