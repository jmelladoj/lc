<template>
    <div>
        <div class="product-item-img" @click="abrirModalVistaDocumento()">
            <a class="product-item-img-link">
                <img v-bind:src="'../' + documento.imagen" alt="Imagen de documento" />
            </a>

            <div class="add-to-link" v-if="documento.timer == 0">
                <a class="btn btn--primary btn--sm" v-if="autenticado == 1" @click="descargar(documento.id)">Descargar</a>
            </div>
            <div class="hover-product-icon">
                <div class="product-icon-btn-wrap">
                    <a href="#" data-toggle="tooltip" data-placement="left" title="Ver" @click="abrirModalVistaDocumento()"><i class="fa fa-search"></i></a>
                </div>
            </div>
        </div>
        <div class="product-item-content">
            <countdown :time="documento.timer * 1000" v-if="documento.timer > 0">
                <template slot-scope="props">
                    <span class="sale-color">
                        Liberado en：{{ props.days }} día(s), {{ props.hours }} hs, {{ props.minutes }} min.
                    </span>
                </template>
            </countdown>
            <div class="text-center"><b><h6 class="titulo-documento"> {{ documento.titulo }} </h6></b></div>
            <div class="text-center" v-text="documento.usuario.tipo_usuario < 3 ? 'Prevención LebenCo.' : documento.usuario.nombre"></div>
            <p class="product-item-price">
                <span class="product-price-amount">
                    <span class="product-price-currency-symbol"></span>
                    <h6 class="titulo-documento mb-0" v-if="documento.valor > 0"> {{ documento.valor | currency}} </h6>
                    <h6 class="titulo-documento mb-0" v-else>Contenido gratuito</h6>
                </span>
            </p>
        </div>

        <b-modal ref="modal_vista_documento" size="lg"  no-close-on-backdrop>
            <template v-slot:modal-header>

                    <div class="col-md-2">
                        <img v-bind:src="'../' + documento.imagen" width="40" alt="Imagen de documento" />
                    </div>
                    <div class="col-md-6">
                        <h3 v-text="modal_vista_documento.titulo"></h3>
                    </div>
                    <div class="col-md-4">
                        <h4 class="font-size-titulo border border-success text-center" v-if="autenticado == 1">Saldo disponible {{ saldo_disponible | currency }} .-</h4>
                        <h4 class="font-size-titulo border border-success text-center" v-else>Descárgalo al iniciar tu sesión</h4>
                    </div>
            </template>

            <b-form>
                <b-form-group class="mb-2">
                    <b-form-textarea readonly="" :value="documento.descripcion" no-resize></b-form-textarea>
                </b-form-group>

                <b-form-group class="mb-0">
                    <h6 class="text-center">Imagen de referencia sobre parte del documento</h6>
                </b-form-group>

                <b-form-group v-show="documento.url_imagen_vista_uno" class="mb-4 text-center">
                    <b-img v-bind:src="'/storage/' + documento.url_imagen_vista_uno" fluid class="center" alt="Vista previa"></b-img>
                </b-form-group>

                <b-form-group v-show="documento.url_imagen_vista_dos">
                    <b-img v-bind:src="'/storage/' + documento.url_imagen_vista_dos" fluid class="center" alt="Vista previa"></b-img>
                </b-form-group>
            </b-form>

            <template slot="modal-footer">
                <b-spinner variant="success" label="Spinning" v-show="spinner.estado == 1"></b-spinner>

                <b-button class="redondear" size="md" variant="success" @click="descargar(documento.id)" v-if="autenticado == 1 && documento.valor > 0 && documento.timer == 0" >{{ documento.valor | currency }} -  Descargar</b-button>
                <b-button class="redondear" size="md" variant="success" @click="descargar(documento.id)" v-if="autenticado == 1 && documento.valor == 0  && documento.timer == 0"> Contenido gratuito -  Descargar</b-button>
                <a class="btn btn-success btn-md text-white redondear" href="javascript:void(0)" v-if="documento.timer != 0">Este documento aún no se libera</a>
                <b-button class="redondear" size="md" variant="danger" @click="cerrarModalVistaDocumento()"> Cerrar </b-button> 

            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        props:[
            'documento', 'autenticado'
        ],
        data() {
            return {
                documentos: [],
                modal_vista_documento: {
                    titulo: '',
                    contenido: ''
                },
                spinner: {
                    estado: 0
                },
                saldo_disponible: 0
            }
        },
        methods:{
            obtener_saldo_usuario(){
                let me = this
                axios.get('/usuario/saldo/disponible').then(function (response) {
                    me.saldo_disponible = response.data.saldo_disponible;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            revisarDocumento(){
                let me=this;

                axios.get('/documentos/busqueda/' + this.categoria.id).then(function (response) {
                    me.documentos = response.data.documentos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirModalVistaDocumento(){
                this.modal_vista_documento.titulo = this.documento.titulo;
                this.modal_vista_documento.contenido = this.documento.descripcion;
                this.$refs['modal_vista_documento'].show();
            },
            cerrarModalVistaDocumento(){
                this.modal_vista_documento.titulo = '';
                this.modal_vista_documento.contenido = '';
                this.$refs['modal_vista_documento'].hide();
            },
            descargar(id){
                Swal.fire({
                    title: '¿Deseas descargar el Documento?',
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

                        me.spinner.estado = 1

                        axios.get('/documento/descargar/' + id).then(function (response) {
                            if(response.data.clase == 'success'){

                                Vue.$toast.open({
			                        message: 'El Documento se descargara pronto!',
			                        type: 'success',
			                        duration: 5000
                                })

                                const link = document.createElement('a')
                                link.href = '/storage/' + response.data.documento.documento_url
                                link.download = response.data.documento.titulo + '.' + response.data.documento.extension
                                document.body.appendChild(link)
                                link.click()

                                me.spinner.estado = 0
                                me.obtener_saldo_usuario()
                            } else {
                            	Vue.$toast.open({
			                        message: response.data.mensaje,
			                        type: response.data.clase,
			                        duration: 5000
			                    });
                            }

                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            }
        },
        mounted() {
            this.obtener_saldo_usuario()
        }
    }
</script>

<style>
    textarea {
        font-size: 16px !important;
    }

    .form-control:disabled, .form-control[readonly] {
        background-color: #fff !important;
        opacity: 1;
        border-color: rgb(138, 183, 51);
    }

    .modal-header {
        border-bottom: 0px solid #e9ecef;
    }

    .modal-footer {
        border-top: 0px solid #e9ecef;
    }

    .modal{
        display: block !important; /* I added this to see the modal, you don't need this */
    }

    /* Important part */
    .modal-dialog{
        overflow-y: initial !important
    }

    .modal-body {
        max-height: calc(100vh - 13rem);
        overflow-y: auto;
    }

    .titulo-documento {
        color:#1E2F13;
        font-weight: 500;
        margin-bottom: 13px !important;
    }

    .font-size-titulo {
        font-size: 16px !important;
    }

    .product-item-normal:hover {
        border: 5px solid #8AB733;
    }

    .product-item-timer:hover {
        border: 5px solid #E8ECD1;
    }
</style>
