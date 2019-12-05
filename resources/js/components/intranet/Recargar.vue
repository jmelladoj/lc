<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Mis recargas</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal()" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Recargar saldo a tu cuenta"><i class="fa fa-plus-circle"></i> Añadir saldo a mi cuenta</b-button>
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

                                <template v-slot:cell(venta)="data">
                                    {{ data.item.monto_venta | currency }}
                                </template>

                                <template v-slot:cell(recarga)="data">
                                    {{ data.item.monto_recarga | currency }}
                                </template>

                                <template v-slot:cell(valido)="data">
                                    <label v-if="data.item.estado == 2">APROBADA</label>
                                    <label v-if="data.item.estado == 1">NO APROBADA</label>
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

            <ValidationObserver ref="observer_servicio" v-slot="{ valid }">
                <b-modal ref="modal_recarga" :title="modal_recarga.titulo" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-form-group label="Dinero a cargar">
                            <ValidationProvider name="carga" rules="required|numeric|min_value:1000" v-slot="{ errors }">
                                <b-form-input type="number" v-model="recarga.monto"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_recarga.accion == 1" size="md" variant="success" @click="recargar"> Recargar </b-button>
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
                recarga: {
                    id: 0,
                    monto: 0
                },
                modal_recarga: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'venta', label: 'VENTA', sortable: true, class: 'text-left' },
                    { key: 'recarga', label: 'RECARGA', sortable: true, class: 'text-left' },
                    { key: 'valido', label: 'ESTADO', sortable: true, class: 'text-left' },
                    { key: 'tipo_tarjeta', label: 'TARJETA', sortable: true, class: 'text-left' },
                    { key: 'created_at', label: 'FECHA', sortable: true, class: 'text-center' }
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
            listarRecargas(){
                let me=this;
                axios.get('/ventas/2').then(function (response) {
                    me.items = response.data.recargas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            recargar(){
                let me = this;

                axios.post('/venta/carga',{
                    'monto': me.recarga.monto
                }).then(function (response) {
                    var form = document.createElement("form");
                    var input_token = document.createElement("input");

                    form.method = "POST";
                    form.action = response.data.url;

                    input_token.value = response.data.token;
                    input_token.name = "TBK_TOKEN";
                    
                    form.appendChild(input_token);
                    document.body.appendChild(form);
                    form.submit();
                }).catch(function (error) {
                    console.error(error);
                });
            },
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el servicio?',
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
                        axios.post('/pagina/servicio/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarServicios();

                            Vue.$toast.open({
		                        message: 'El sevicios ha sido borrado!',
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
                this.modal_recarga.titulo = "";
                this.modal_recarga.accion = 0;
                this.$refs['modal_recarga'].hide();
            },
            abrirModal(){
                let me = this;
                this.limpiarRecarga();

                me.modal_recarga.titulo = "Cargar saldo";
                me.modal_recarga.accion = 1;

                this.$refs['modal_recarga'].show();
            },
            limpiarRecarga(){
                this.recarga.id = 0;
                this.recarga.monto = 0;      
            }
        },
        mounted() {
            this.listarRecargas();
        }
    }
</script>
