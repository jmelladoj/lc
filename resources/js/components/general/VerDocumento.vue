<template>
    <div>
        <div class="product-item-img" @click="abrirModalVistaDocumento()">
            <a class="product-item-img-link">
                <img v-bind:src="'../' + documento.imagen" alt="Imagen de documento" />
            </a>

            <div class="add-to-link">
                <a class="btn btn--primary btn--sm" v-if="autenticado == 1" @click="descargar(documento.id)">Descargar</a>
            </div>
            <div class="hover-product-icon">
                <div class="product-icon-btn-wrap">
                    <a href="#" data-toggle="tooltip" data-placement="left" title="Ver" @click="abrirModalVistaDocumento()"><i class="fa fa-search"></i></a>
                </div>
            </div>
        </div>
        <div class="product-item-content">
            <div class="text-center"><b class="titulo-documento">{{ documento.titulo }}</b></div>
            <div class="text-center" v-text="documento.usuario.tipo_usuario < 3 ? 'Autor: Prevención LebenCo.' : 'Autor : ' + documento.usuario.nombre"></div>
            <p class="product-item-price">
                <span class="product-price-amount">
                    <span class="product-price-currency-symbol"></span>{{ documento.valor | currency}}
                </span>
            </p>
        </div>

        <b-modal ref="modal_vista_documento" :title="modal_vista_documento.titulo"  size="lg"  no-close-on-backdrop>
            <b-form>
                <b-form-group class="mb-4">
                    <b-form-textarea readonly="" :value="documento.descripcion" no-resize></b-form-textarea>
                </b-form-group>

                <b-form-group class="mb-0">
                    <h6 class="text-center">Imagen de referencia sobre parte del documento</h6>
                </b-form-group>

                <b-form-group v-show="documento.url_imagen_vista_uno" class="mb-4">
                    <b-img v-bind:src="'/storage/' + documento.url_imagen_vista_uno" fluid class="center" alt="Vista previa"></b-img>
                </b-form-group>

                <b-form-group v-show="documento.url_imagen_vista_dos">
                    <b-img v-bind:src="'/storage/' + documento.url_imagen_vista_dos" fluid class="center" alt="Vista previa"></b-img>
                </b-form-group>
 
            </b-form>

            <template slot="modal-footer">
                <b-button size="md" variant="success" @click="descargar(documento.id)" v-if="autenticado == 1">{{ documento.valor | currency }} -  Descargar</b-button>
                <b-button size="md" variant="danger" @click="cerrarModalVistaDocumento()"> Cerrar </b-button>
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
                }
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

                        axios.get('/documento/descargar/' + id).then(function (response) {         
                            if(response.data.clase == 'success'){
                                me.mensaje('success', 'El Documento se descargara pronto!');
                                
                                const link = document.createElement('a');
                                link.href = '/storage/' + response.data.documento.documento_url;
                                link.download = response.data.documento.titulo + '.' + response.data.documento.extension;
                                document.body.appendChild(link);
                                link.click();
                            } else {
                                me.mensaje(response.data.clase, response.data.mensaje);
                            }              
                            
                        }).catch(function (error) {
                            console.log(error.response.data);
                        });


                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            }
        },
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
        color: #3F8A24;
    }

</style>