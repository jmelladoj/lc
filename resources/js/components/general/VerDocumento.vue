<template>
    <div>
        <div class="product-item-img">
            <a class="product-item-img-link">
                <img v-bind:src="'../' + documento.imagen" alt="Imagen de documento" />
            </a>

            <div class="add-to-link">
                <a class="btn btn--primary btn--sm" v-if="autenticado == 1">Descargar</a>
            </div>
            <div class="hover-product-icon">
                <div class="product-icon-btn-wrap">
                    <a href="#" data-toggle="tooltip" data-placement="left" title="Ver" @click="abrirModalVistaDocumento()"><i class="fa fa-search"></i></a>
                </div>
            </div>
        </div>
        <div class="product-item-content">
            <div class="text-center"><b>{{ documento.titulo }}</b></div>
            <div class="text-center" v-text="'Autor:' + documento.usuario.nombre"></div>
            <p class="product-item-price">
                <span class="product-price-amount">
                    <span class="product-price-currency-symbol">$</span>{{ documento.valor}}
                </span>
            </p>
        </div>

        <b-modal ref="modal_vista_documento" :title="modal_vista_documento.titulo" size="lg" no-close-on-backdrop>
            <b-form>
                <b-row>
                    <b-col>
                        <p class="text-justify" v-text="documento.descripcion"></p>
                    </b-col>
                </b-row>
            </b-form>

            <template slot="modal-footer">
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
            }
        },
    }
</script>
