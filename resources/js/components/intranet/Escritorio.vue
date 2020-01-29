<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Escritorio</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                    </div>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card-group>
                        <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2><i class="fa fa-credit-card"></i></h2>
                                        <h4 class="text-muted"><b>Mi saldo</b></h4>
                                    </div>
                                    <div class="ml-auto">
                                        <h2 class="counter text-primary">{{ usuario.saldo |currency }} </h2>
                                        <b-button size="md" variant="success" @click="$root.menu = 12">Recargar</b-button>
                                    </div>
                                </div>
                            </b-col>
                        </b-card>
                        <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div id="myCarouse2" class="slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div v-for="(tip, index) in tips" :key="index" class="carousel-item" v-bind:class="index == 0 ? 'active' : ''">
                                            <center>
                                                <h3 v-text="tip.nombre"></h3>
                                                <b-button size="md" variant="success" @click="abrir_modal_tip(tip)">Ver más</b-button>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </b-col>
                        </b-card>
                    </b-card-group>
                </b-col>
            </b-row>


            <b-row>
                <b-col :cols="pagina.contenido.length > 0 ? 8 : 12">
                    <b-card title="Documentos recomendados">
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

                <b-col v-show="pagina.contenido.length > 0" cols="4">
                    <b-card bg-variant="success" text-variant="white" >
                        <b-card-text>
                            <b-row>
                                <p class="text-justify">
                                    {{ pagina.contenido }}
                                </p>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <div  v-show="pagina.url_imagen.length > 0"  class="clearfix">
                                        <b-img v-show="pagina.url_imagen.length > 0" :src="'storage/' + pagina.url_imagen" center fluid class="maxima-altura"></b-img>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>


            <b-modal ref="modal_tip" :title="modal_tip.titulo" no-close-on-backdrop>
                <b-form>
                    <p class="text-justify">
                        {{ modal_tip.descripcion }}
                    </p>
                </b-form>

                <template slot="modal-footer">
                    <b-button size="md" variant="danger" @click="cerrar_modal_tip"> Cerrar </b-button>
                </template>
            </b-modal>

            <b-modal v-if="mensaje != undefined" title="¡Bienvenido!" :visible="true" >
                <h2 class="text-center">¡Felicidades!</h2>
                <p class="my-4 text-justify">
                    Ya eres parte de nuestra Comunidad Prevención LebenCo. y para celebrar, te damos una recarga inicial para que puedas descargar tu primer documento.
                </p>
            </b-modal>

        </b-container>

    </div>
</template>

<script>
    export default {
        props: [
            'mensaje'
        ],
        data() {
            return {
                pagina: {
                    contenido: '',
                    url_imagen: ''
                },
                usuario: {
                    saldo: 0
                },
                modal_tip: {
                    titulo: '',
                    descripcion: ''
                },
                tips: [],
                items: [],
                subtips: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'titulo', label: 'Título', sortable: true, class: 'text-left' },
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
            obtener_saldo() {
                let saldo_usuario = $('#saldo_usuario').val()
                this.usuario.saldo = saldo_usuario
            },
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listarPagina (){
                let me=this;
                axios.get('/pagina/home/usuario').then(function (response) {
                    me.pagina.contenido = response.data.pagina.contenido
                    me.pagina.url_imagen = response.data.pagina.video_url;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarTips (){
                let me=this;
                axios.get('/tips').then(function (response) {
                    me.tips = response.data.tips;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarDocumentos(){
                let me=this;
                axios.get('/documentos/tipo/2').then(function (response) {
                    me.items = response.data.ddocumentos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrir_modal_tip(data){
                this.modal_tip.titulo = data.nombre
                this.modal_tip.descripcion = data.descripcion

                this.$refs['modal_tip'].show();
            },
            cerrar_modal_tip(){
                this.modal_tip.titulo = ''
                this.modal_tip.descripcion = ''

                this.$refs['modal_tip'].hide();
            }
        },
        beforeMount() {
            this.listarTips();
            this.obtener_saldo()
            this.listarPagina()
        }
    }
</script>
