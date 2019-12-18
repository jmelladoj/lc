<template>
    <section class="sec-padding" v-show="documentos.length > 0">
        <div class="container">
            <div class="page-head">
                <span class="page-sub-title"></span>
                <h2 class="page-title" v-text="titulo"></h2>
            </div>
        </div>
        <div class="container justify-content-center">
            <carousel :per-page="4" :autoplay="true" :navigationEnabled="true">
                <slide v-for="(documento, index) in documentos" :key="index"> 
                    <div class="product-item ml-2 mr-2">
                        <div class="product-item-img">
                            <a class="product-item-img-link">
                                <img v-bind:src="documento.imagen" alt="Imagen de documento" />
                            </a>

                            <div class="add-to-link">
                                <div class="card">
                                    <p class="text-justify" v-text="documento.descripcion"></p>
                                </div>
                                <br>
                                <a class="btn btn--primary btn--sm" v-if="autenticado == 1">Descargar</a>
                            </div>
                        </div>
                    </div>
                </slide>
            </carousel>
        </div>
    </section>
</template>

<script>
    export default {
        props:[
            'tipo', 'titulo', 'autenticado'
        ],  
        data() {
            return {
                documentos: []
            }
        },  
        methods:{
            listarDocumentos(){
                let me=this;
                axios.get('/documentos/tipo/' + this.tipo).then(function (response) {
                    me.documentos = response.data.documentos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarDocumentos();
        }
    }
</script>
