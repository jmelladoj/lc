<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Solicitudes de documentos</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Solicitar documento"><i class="fa fa-plus-circle"></i> Solicitar documento</b-button>
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

                            <template v-slot:cell(usuario)="data">
                                {{ data.item.usuario.nombre }}
                            </template>

                            <template v-slot:cell(pago)="data">
                                {{ data.item.valor | currency }}
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

    <ValidationObserver ref="observer_solicitud_documento" v-slot="{ valid }">
        <b-modal ref="modal_solicitud_documento" title="Solicitar documento" no-close-on-backdrop scrollable>
            <b-form>
                <b-form-group label="Describe tu requerimiento ...">
                    <ValidationProvider name="requerimiento" rules="required|min:10" v-slot="{ errors }">
                        <b-form-textarea v-model="solicitud.descripcion" rows="3" max-rows="6"></b-form-textarea>
                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                    </ValidationProvider>
                </b-form-group>

                <b-form-group label="¿Cuánto estás dispuesto a pagar?">
                    <ValidationProvider name="pago" rules="required|numeric|min_value:1" v-slot="{ errors }">
                        <b-form-input type="number" v-model="solicitud.pago"></b-form-input>
                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                    </ValidationProvider>
                </b-form-group>

                <b-form-group label="Plazo de entrega (días) ...">
                    <ValidationProvider name="plazo" rules="required|numeric|min_value:1" v-slot="{ errors }">
                        <b-form-input type="number" v-model="solicitud.plazo"></b-form-input>
                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                    </ValidationProvider>
                </b-form-group>

                <b-form-group label="Observación">
                    <b-alert variant="warning" show class="text-justify">
                        Recuerda que debes ser conciente con la valoración del trabajo de los profesionales, de lo contrario te arriesgas a que tu propuesta no sea atractiva para la comunidad. <br><br>
                        Para asegurar el cumplimiento de la entrega, considera que para cualquier documento escencial el plazo es 24hrs, pero si el documento es complejo este plazo base puede incrementarse y al igual que el monto.<br><br>
                        Considera que se descontará inmediatamente de tu saldo, el monto a pago que propones.
                    </b-alert>
                </b-form-group>

            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="!valid" size="md" variant="success" @click="solicitarDocumento()"> Enviar pedido </b-button>
                <b-button size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
            </template>
        </b-modal>
    </ValidationObserver>

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
                    { key: 'descripcion', label: 'SOLICITUD', sortable: true, class: 'text-justify' },
                    { key: 'plazo', label: 'PLAZO (DÍAS)', sortable: true, class: 'text-left' },
                    { key: 'pago', label: 'PAGA', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
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
            abrirModal(){
                this.$refs['modal_solicitud_documento'].show();
            },
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listarSolicitudes (){
                let me=this;
                axios.get('/solicitudes/documento').then(function (response) {
                    me.items = response.data.solicitudes;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            solicitarDocumento(){
                let me = this;
                axios.post('/solicitar/documento',{
                    'descripcion': me.solicitud.descripcion,
                    'pago': me.solicitud.pago,
                    'plazo': me.solicitud.plazo
                }).then(function (response) {
                    let saldo_usuario = $('#saldo_usuario').val()
                    saldo_usuario -= me.solicitud.pago

                    $('#saldo_usuario').val(saldo_usuario)

                    $('#saldo').text('');
                    $('#saldo').text(saldo_usuario);

                    Vue.$toast.open({
                        message: response.data.mensaje,
                        type: response.data.clase,
                        duration: 5000
                    });

                    me.cerrarModal();

                }).catch(function (error) {
                    console.error(error);
                });
            },
            cerrarModal(){
                this.$refs['modal_solicitud_documento'].hide();
            },
            limpiar_datos_modal(){
                this.solicitud.descripcion = "";
                this.solicitud.pago = 0;
                this.solicitud.plazo = 0;
            }
        },
        mounted() {
            this.listarSolicitudes();
        }
    }
</script>
