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

                                    <template v-slot:cell(usuario)="data">
                                        {{ data.item.usuario.nombre }}
                                    </template>

                                    <template v-slot:cell(telefono)="data">
                                        +56 9 {{ data.item.usuario.telefono }}
                                    </template>

                                    <template v-slot:cell(email)="data">
                                        {{ data.item.usuario.email }}
                                    </template>

                                    <template v-slot:cell(acciones)="row">

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
                    { key: 'usuario', label: 'USUARIO', sortable: true, class: 'text-left' },
                    { key: 'telefono', label: 'TELÉFONO', sortable: true, class: 'text-left' },
                    { key: 'email', label: 'EMAIL', sortable: true, class: 'text-left' },
                    { key: 'created_at', label: 'FECHA', sortable: true, class: 'text-left' },
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
            listarAsesorias (){
                let me=this;
                axios.get('/asesorias').then(function (response) {
                    me.items = response.data.asesorias;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarAsesorias();
        }
    }
</script>