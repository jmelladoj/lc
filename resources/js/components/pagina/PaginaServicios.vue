<template>
     <section class="sec-padding-login">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12">
                    <p>
                        {{ pagina.mensaje }}
                    </p>
                </div>
            </div>
            <div v-for="item in items" :key="item.id" class="card mb-3">
                <div class="row mt-0 ml-0 mr-0 mb-0">
                    <div class="col-md-2 mx-auto my-auto  mt-0 ml-0 mr-0 mb-0">
                        <div class="text-center ">
                            <img :src="'storage/' + item.imagen_url" height="100"/>
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto my-auto  mt-0 ml-0 mr-0 mb-0">
                        <div class="blog-item mr-5">
                            <h4 class="blog-title"><a href="javascript:void(0)">{{ item.nombre }}</a></h4>
                            <div class="blog-description-content">
                                <p class="text-justify">
                                    {{ item.descripcion }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mx-auto my-auto  mt-0 ml-0 mr-0 mb-0">
                        <b-button v-if="item.cantidad > 0" variant="success" size="md" class="boton_redondo" @click="abrir_modal_detalle(item)">Ver más</b-button>
                    </div>
                </div>
            </div>
        </div>

        <b-modal size="lg" ref="modal_detalle" :title="modal_detalle.titulo" no-close-on-backdrop scrollable>
            <b-card>
                <div  v-for="(item, index) in items_sub_servicio" :key="index">
                    <h3 class="text-left">{{ item.nombre }}</h3>
                    <p class="text-justify">
                        {{ item.descripcion }}
                    </p>
                    <hr />
                </div>

            </b-card>

            <template slot="modal-footer">
                <b-button size="md" variant="danger" class="boton_redondo" @click="cerrar_modal_detalle()"> Cerrar </b-button>
            </template>
        </b-modal>
    </section>
</template>


<script>
    const items = [];

    export default {
        data() {
            return {
                pagina: {
                    mensaje: ''
                },
                servicio: {
                    id: 0,
                    nombre: '',
                    descripcion: '',
                    imagen_url: null
                },
                sub_servicio: {
                    id: 0,
                    nombre: '',
                    descripcion: ''
                },
                modal_detalle: {
                    titulo: ''
                },
                items: items,
                items_sub_servicio: items,
            }
        },

        methods:{
            listarMensajeServicios(){
                let me=this;
                axios.get('/pagina/servicios/mensaje').then(function (response) {
                    me.pagina.mensaje = response.data.pagina.mensaje_uno;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarServicios (){
                let me=this;
                axios.get('/pagina/servicios/intranet').then(function (response) {
                    me.items = response.data.servicios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_sub_servicios (){
                let me=this;
                axios.get('/pagina/subservicios/' + me.servicio.id).then(function (response) {
                    me.items_sub_servicio = response.data.servicios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                this.modal_servicio.titulo = "";
                this.modal_servicio.accion = 0;
                this.$refs['modal_servicio'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosServicio();

                if(accion == 1){
                    me.modal_servicio.titulo = "Agregar Servicio";
                    me.modal_servicio.accion = 1;
                } else if(accion == 2){
                    me.modal_servicio.titulo = "Modificar Servicio";
                    me.modal_servicio.accion = 2;

                    me.servicio.id = data['id'];
                    me.servicio.nombre = data['nombre'];
                    me.servicio.descripcion = data['descripcion'];
                    me.servicio.imagen_url = 'storage/' + data['imagen_url'];
                }

                this.$refs['modal_servicio'].show();
            },
            abrir_modal_detalle(data = []){
                this.modal_detalle.titulo = 'Detalle de ' + data.nombre
                this.servicio.id = data.id
                this.listar_sub_servicios()
                this.$refs['modal_detalle'].show();
            },
            cerrar_modal_detalle(){
                this.modal_detalle.titulo = ''
                this.servicio.id = 0
                this.$refs['modal_detalle'].hide();
            }
        },
        mounted() {
            this.listarMensajeServicios();
            this.listarServicios();
        }
    }
</script>
