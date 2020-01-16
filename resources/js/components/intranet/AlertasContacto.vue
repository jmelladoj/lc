<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor" v-text="'Alertas desde contacto'"></h4></b-col>
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

                                    <template v-slot:cell(contacto)="data">
                                        {{ data.item.data.usuario.nombre + ' - +56 9 ' + data.item.data.usuario.telefono + ' - ' + data.item.data.usuario.email }}
                                    </template>

                                    <template v-slot:cell(mensaje)="data">
                                        {{ data.item.data.mensaje }}
                                    </template>

                                    <template v-slot:cell(tipo)="data">
                                        <label v-if="data.item.data.usuario.tipo_persona == 1"> Persona </label>
                                        <label v-else-if="data.item.data.usuario.tipo_persona == 2"> Pyme </label>
                                        <label v-else-if="data.item.data.usuario.tipo_persona == 3"> Estudiante </label>
                                    </template>

                                    <template v-slot:cell(acciones)="row">
                                        <b-button v-if="row.item.read_at == null" size="xs" variant="success" title="Marcar notificación como leída" @click="leerNotificacion(row.item)">
                                            <i class="fa fa-check"></i>
                                        </b-button>

                                        <label v-else for="" class="text-center">Leída</label>
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
                    { key: 'contacto', label: 'Contacto', sortable: true, class: 'text-left' },
                    { key: 'tipo', label: 'Tipo cliente', sortable: true, class: 'text-left' },
                    { key: 'mensaje', label: 'Mensaje', sortable: true, class: 'text-left' },
                    { key: 'created_at', label: 'Fecha solicitud', sortable: true, class: 'text-left' },
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
            listarAlertas (){
                let me=this;

                axios.get('/notificaciones/3').then(function (response) {
                    me.items = response.data.alertas;
                    me.items = me.items.filter(item => item.data.tipo_notificacion == 9)
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            leerNotificacion(id){
                let me = this;

                axios.post('/notificacion/leer',{
                    'id': id
                }).then(function (response) {
                    me.listarAlertas();

                    Vue.$toast.open({
                        message: 'Notificacion marcada como leída',
                        type: 'success',
                        duration: 5000
                    });

                    Event.$emit('marcar', id);
                }).catch(function (error) {
                    console.error(error);
                });
            }
        },
        mounted() {
            this.listarAlertas();
        }
    }
</script>