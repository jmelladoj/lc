<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Tabla VIP</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="$root.menu = 5" class="btn btn-success d-lg-block m-l-15" v-b-tooltip title="Agrega un usuario a la plataforma"><i class="fa fa-arrow-left"></i> Volver a usuarios</b-button>
                    </div>
                </b-col>
            </b-row>

            <b-card>
                <b-row>
                    <b-col>
                        <b-form-group label="Cliente">
                            <b-form-input v-model="tabla.empresa" type="text" readonly="" placeholder="Pyme"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Categoría">
                            <ValidationProvider name="posición" rules="required|numeric|between:0,10" v-slot="{ errors }">
                                <b-form-select v-model="tabla.posicion" @change="actualizar_usuario_tabla">
                                    <option value="0">Estrellas</option>
                                    <option value="1">1 Estrella(s)</option>
                                    <option value="2">2 Estrella(s)</option>
                                    <option value="3">3 Estrella(s)</option>
                                    <option value="4">4 Estrella(s)</option>
                                    <option value="5">5 Estrella(s)</option>
                                </b-form-select>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Likes">
                            <ValidationProvider name="likes" rules="required|numeric|between:1,100" v-slot="{ errors }">
                                <b-form-input type="number" v-model="tabla.likes" placeholder="Likes" @keyup="actualizar_usuario_tabla"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Dislikes">
                            <ValidationProvider name="dislikes" rules="required|numeric|between:1,100" v-slot="{ errors }">
                                <b-form-input type="number" v-model="tabla.dislikes" placeholder="Dislikes" disabled=""></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-card>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid>

                                <b-row>
                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter_pyme" placeholder="Escribe para buscar" />
                                            <b-input-group-append>
                                            <b-button :disabled="!filter_pyme" @click="filter_pyme = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Ordenar" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortBy_pyme" :options="sortOptions_pyme">
                                            <option slot="first" :value="null">-- nada --</option>
                                            </b-form-select>
                                            <b-form-select :disabled="!sortBy_pyme" v-model="sortDesc_pyme" slot="append">
                                            <option :value="false">Asc</option> <option :value="true">Desc</option>
                                            </b-form-select>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Dirección" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortDirection_pyme" slot="append">
                                            <option value="asc">Asc</option> <option value="desc">Desc</option>
                                            <option value="last">Último</option>
                                            </b-form-select>
                                        </b-input-group>
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
                                    :items="items_pyme"
                                    :fields="fields_pyme"
                                    :current-page="currentPage_pyme"
                                    :per-page="perPage_pyme"
                                    :filter="filter_pyme"
                                    :sort-by.sync="sortBy_pyme"
                                    :sort-desc.sync="sortDesc_pyme"
                                    :sort-direction="sortDirection_pyme"
                                    @filtered="onFiltered_pyme">

                                    <template slot="empty">
                                        <center><h5>No hay registros para mostrar.</h5></center>
                                    </template>

                                    <template slot="emptyfiltered">
                                        <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                    </template>

                                    <template v-slot:cell(nombre)="row">
                                        <label  @click="actualizar_tabla(row.item)" v-text="row.item.nombre"></label>
                                    </template>

                                    <template v-slot:cell(tipo)="data">
                                        <label v-if="data.item.tipo_persona == 1"> Persona </label>
                                        <label v-else-if="data.item.tipo_persona == 2"> Pyme </label>
                                        <label v-else-if="data.item.tipo_persona == 3"> Estudiante </label>
                                    </template>


                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="warning" title="Actualizar usuario" @click="actualizar_tabla(row.item)">
                                            <i class="fa fa-pencil"></i>
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

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid>

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
                                        <b-form-group label-cols-sm="3" label="Dirección" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortDirection" slot="append">
                                            <option value="asc">Asc</option> <option value="desc">Desc</option>
                                            <option value="last">Último</option>
                                            </b-form-select>
                                        </b-input-group>
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

                                    <template v-slot:cell(nombre)="row">
                                        <label  @click="actualizar_tabla(row.item)" v-text="row.item.nombre"></label>
                                    </template>

                                    <template v-slot:cell(tipo)="data">
                                        <label v-if="data.item.tipo_persona == 1"> Persona </label>
                                        <label v-else-if="data.item.tipo_persona == 2"> Pyme </label>
                                        <label v-else-if="data.item.tipo_persona == 3"> Estudiante </label>
                                    </template>


                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="warning" title="Actualizar usuario" @click="actualizar_tabla(row.item)">
                                            <i class="fa fa-pencil"></i>
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
        </b-container>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                items: [],
                items_pyme: [],
                tabla: {
                    usuario_id: 0,
                    empresa: null,
                    posicion: 0,
                    likes: null,
                    dislikes: null
                },
                fields: [
                    { key: 'posicion', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Pyme', sortable: true, class: 'text-left' },
                    { key: 'nombreComuna', label: 'Comuna', sortable: true, class: 'text-left' },
                    { key: 'nombreRubro', label: 'Rubro', sortable: true, class: 'text-left' },
                    { key: 'likes', label: 'Likes', sortable: true, class: 'text-center' },
                    { key: 'dislikes', label: 'Dislikes', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                fields_pyme: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'tipo_comentario', label: 'Tipo comentario', sortable: true, class: 'text-left' },
                    { key: 'comentario', label: 'Comentario', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                currentPage_pyme: 1,
                perPage_pyme: 10,
                totalRows_pyme: 0,
                pageOptions_pyme: [10, 25, 50, 100],
                sortBy_pyme: null,
                sortDesc_pyme: false,
                sortDirection_pyme: 'asc',
                filter_pyme: null,
            }
        },
        computed: {
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            },
            sortOptions_pyme() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods: {
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            onFiltered_pyme(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listarUsuariosTablaVip(){
                let me=this;
                axios.get('/usuarios/tabla/vip').then(function (response) {
                    me.items = response.data.usuarios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizar_tabla(data = []){
                this.tabla.usuario_id = data.id
                this.tabla.empresa = data.nombre
                this.tabla.posicion = data.posicion
                this.tabla.likes = data.likes
                this.tabla.dislikes = data.dislikes

                this.actualizar_porcentajes()
            },
            actualizar_usuario_tabla(){
                let me = this;

                this.actualizar_porcentajes()

                if(this.tabla.likes > 100){
                    return false
                }

                axios.post('/usuario/actualizar/tabla/vip',{
                    'id': me.tabla.usuario_id,
                    'posicion': me.tabla.posicion,
                    'likes': me.tabla.likes,
                    'dislikes': me.tabla.dislikes
                }).then(function (response) {
                    me.listarUsuariosTablaVip();

                    Vue.$toast.open({
                        message: 'Cambio guardado exitosamente!',
                        type: 'success',
                        duration: 2000
                    });


                }).catch(function (error) {
                    console.error(error);
                });
            },
            actualizar_porcentajes(){
                let porcentaje = 100
                this.tabla.dislikes = parseInt(porcentaje) - parseInt(this.tabla.likes)
            }
        },
        mounted(){
            this.listarUsuariosTablaVip()
        }
    }
</script>
