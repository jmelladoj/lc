<template>
    <b-container fluid>
        <b-row class="mb-3">
            <b-col md="6" class="my-1">
                <b-form-group class="mb-0">
                <b-input-group>
                    <b-form-input v-model="filter" placeholder="Escribe un rubro para buscar"  class="altura-form-control"/>
                    <b-input-group-append>
                    <b-button class="boton_chico" size="sm" :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                    </b-input-group-append>
                </b-input-group>
                </b-form-group>
            </b-col>

            <b-col md="6" class="my-1">
                <b-form-group class="mb-0">
                <b-input-group>
                    <b-form-input v-model="filter" placeholder="Escribe una comuna para buscar" class="altura-form-control"/>
                    <b-input-group-append>
                    <b-button class="boton_chico" size="sm" :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                    </b-input-group-append>
                </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>
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


            <template v-if="tipo == 1" v-slot:cell(lugar)="data">
                {{ posiciones[data.index] }}
            </template>

            <template v-else v-slot:cell(lugar)="data">
                <center>{{ data.index + 1 }}</center>
            </template>

            <template v-slot:cell(nombre_comuna)="data">
                {{ data.item.comuna.nombre }}
            </template>
            
            <template v-slot:cell(valoracion)="data">
                A {{ data.item.likes }} % les gusta esto.
            </template>

            <template v-slot:cell(nombre_rubro)="data">
                Sin rubro
            </template>

            <template v-slot:cell(like)="data">
                <a href="javascript:void(0)" @click="abrirModalValoracion(1, data.item)"> {{ data.item.likes }} % <i class="ml-1 fa fa-thumbs-up sale-color"></i></a>
            </template>

            <template v-slot:cell(dislike)="data">
                <a href="javascript:void(0)" @click="abrirModalValoracion(2, data.item)"> {{ data.item.dislikes }} % <i class="ml-1 fa fa-thumbs-down sale-color"></i></a>
            </template>

            <template v-slot:cell(perfil)="data">
                <a href="javascript:void(0)" class="h4" title="Ver perfil de usuario" @click="abrirModalPerfil(data.item)"><i class="fa fa-user sale-color"></i></a>
            </template>

        </b-table>

        <ValidationObserver ref="observer_votacion" v-slot="{ valid }">
            <b-modal ref="modal_votacion" :title="modal_votacion.titulo" size="md" no-close-on-backdrop>
                <b-form>
                    <b-form-group v-show="logeado == 1" :label="modal_votacion.accion == 1 ? '¿Qué te ha gustado de la pyme?' : '¿Qué no te ha gustado de la Pyme?'">
                        <ValidationProvider name="valoración" rules="required|min:20|max:200" v-slot="{ errors }">
                            <b-form-textarea v-model="valoracion.descripcion" placeholder="Escribe aquí ..." rows="3" max-rows="6"></b-form-textarea>
                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                        </ValidationProvider>
                    </b-form-group>

                    <b-alert variant="warning" class="text-justify" show>
                        Debes de iniciar sesión en la plataforma para poder votar.
                    </b-alert>
                </b-form>

                <template slot="modal-footer">
                    <b-button :disabled="!valid" v-show="logeado == 1" size="md" variant="success" @click="enviarValoracion()"> Guardar </b-button>
                    <b-button size="md" variant="danger" @click="cerrarModalValoracion()"> Cerrar </b-button>
                </template>
            </b-modal>
        </ValidationObserver>

        <ValidationObserver ref="observer_usuario" v-slot="{ valid }">
            <b-modal ref="modal_perfil" :title="modal_perfil.titulo" size="lg" no-close-on-backdrop>

                <b-form>
                    <perfil_usuario :usuario_id="usuario.id" :tipo_usuario_logeado="4"></perfil_usuario>
                </b-form>

                <template slot="modal-footer">
                    <b-button size="md" variant="danger" @click="cerrarModalPerfil()"> Cerrar </b-button>
                </template>
            </b-modal>
        </ValidationObserver>
    </b-container>
</template>

<script>
    const items = [];

    export default {
        props: [
            'tipo', 'logeado'
        ],
        data() {
            return {
                usuario: {
                    id: 0
                },
                valoracion: {
                    descripcion: ''
                },
                pyme: {
                    id: 0
                },
                modal_votacion: {
                    titulo: '',
                    accion: 0
                },
                modal_perfil: {
                    titulo: ''
                },
                posiciones: [
                    '1er lugar', '2do lugar', '3er lugar', '4to lugar', '5to lugar'
                ],
                items: items,
                fields: [],
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
            ocultar(clase){

            },
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listarPymes (){
                let me=this;
                axios.get('/usuarios/pymes/' + this.tipo).then(function (response) {
                    me.items = response.data.usuarios;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirModalValoracion(accion, data = []){
                let me = this;

                me.valoracion.descripcion = '';
                me.modal_votacion.titulo = 'Valorando a ' + data['nombre'];
                me.modal_votacion.accion = accion;

                this.$refs['modal_votacion'].show();
            },
            cerrarModalValoracion(){
                let me = this;

                me.modal_votacion.titulo = '';
                me.modal_votacion.accion = 0;
                this.$refs['modal_votacion'].hide();
            },
            enviarValoracion (){
                let me = this;

                axios.post('/valorar/pyme',{
                    'descripcion': me.valoracion.descripcion,
                    'accion': me.modal_votacion.accion
                }).then(function (response) {
                    me.listarPymes();
                    me.cerrarModalValoracion();

                    Vue.$toast.open({
                        message: 'Muchas gracias por tu valoración',
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            },
            abrirModalPerfil(data = []){
                let me = this;

                me.modal_perfil.titulo = 'Perfil de ' + data['nombre']; 
                me.usuario.id = data['id'];

                this.$refs['modal_perfil'].show();
            },
            cerrarModalPerfil(){
                let me = this;

                me.modal_perfil.titulo = ''; 
                me.usuario.id = 0;

                this.$refs['modal_perfil'].hide();
            }
        },
        mounted() {
            this.listarPymes();

            if(this.logeado == 0){
                if(this.tipo == 1){
                    this.fields = [
                        { key: 'lugar', label: 'Posición', sortable: true, sortDirection: 'desc', class: 'text-center' },
                        { key: 'nombre', label: 'Nombre de la Pyme', sortable: true, class: 'text-center' },
                        { key: 'nombre_comuna', label: 'Comuna', sortable: true, class: 'text-center' },
                        { key: 'nombre_rubro', label: 'Rubro', sortable: true, class: 'text-center' },
                        { key: 'perfil', label: 'Perfil', sortable: true, class: 'text-center' },
                        { key: 'valoracion', label: 'Valoración', sortable: true, class: 'text-center' },
                    ]
                } else {
                    this.fields = [
                        { key: 'nombre', label: 'Nombre de la Pyme', sortable: true, class: 'text-center' },
                        { key: 'nombre_comuna', label: 'Comuna', sortable: true, class: 'text-center' },
                        { key: 'nombre_rubro', label: 'Rubro', sortable: true, class: 'text-center' },
                        { key: 'perfil', label: 'Perfil', sortable: true, class: 'text-center' },
                        { key: 'valoracion', label: 'Valoración', sortable: true, class: 'text-center' },
                    ]
                }
                
            } else {

                if(this.tipo == 1){
                    this.fields = [
                        { key: 'lugar', label: 'Posición', sortable: true, sortDirection: 'desc', class: 'text-center' },
                        { key: 'nombre', label: 'Nombre de la Pyme', sortable: true, class: 'text-center' },
                        { key: 'nombre_comuna', label: 'Comuna', sortable: true, class: 'text-center' },
                        { key: 'nombre_rubro', label: 'Rubro', sortable: true, class: 'text-center' },
                        { key: 'perfil', label: 'Perfil', sortable: true, class: 'text-center' },
                        { key: 'valoracion', label: 'Valoración', sortable: true, class: 'text-center' },
                        { key: 'like', label: 'Me gusta', sortable: true, class: 'text-center like' },
                        { key: 'dislike', label: 'No me gusta', sortable: true, class: 'text-center dislike' }
                    ]
                } else {
                    this.fields = [
                        { key: 'nombre', label: 'Nombre de la Pyme', sortable: true, class: 'text-center' },
                        { key: 'nombre_comuna', label: 'Comuna', sortable: true, class: 'text-center' },
                        { key: 'nombre_rubro', label: 'Rubro', sortable: true, class: 'text-center' },
                        { key: 'perfil', label: 'Perfil', sortable: true, class: 'text-center' },
                        { key: 'valoracion', label: 'Valoración', sortable: true, class: 'text-center' },
                        { key: 'like', label: 'Me gusta', sortable: true, class: 'text-center like' },
                        { key: 'dislike', label: 'No me gusta', sortable: true, class: 'text-center dislike' }
                    ]
                }
            }
        }
    }
</script>

<style>
    .table thead th {
        background-color:#8AB733;
        color: #E8ECD1;
        border-color: #8AB733 2px solid !important;
    }

    .table tbody tr h5 {
        color: #1E2F13;
    }

    .table-striped tbody tr:nth-of-type(2n+1) {
        background-color: 
        rgba(0, 0, 0, 0.05);
    }

    .altura-form-control {
        max-height: 30px !important;
    }

    .boton_chico {
        padding-top: 0px !important;
        padding-bottom: 0px !important;
        border-bottom-right-radius: 40px !important;
        color:  #1E2F13 !important;
        background-color: #E8ECD1 !important;
        font-size: 14px !important;
    }

    .table thead th {
        font-size: 18px !important;
    }
</style>