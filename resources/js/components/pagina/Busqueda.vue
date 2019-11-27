<template>
    <div>
        <section class="breadcrumb">
            <div class="breadcrumb-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="breadcrumb-title" v-text="categoria.nombre"></h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sec-padding">
            <div class="container">
                <div class="row">
                    <div v-show="documentos.length > 0" class="col-md-2 product-item mb-4" v-for="documento in documentos"  :key="documento.id">
                        <ver-documento :documento="documento" :autenticado="autenticado"></ver-documento>
                    </div>

                    <div class="col-md-12" v-if="documentos.length == 0"><h4 class="text-center">Sin resultados.</h4></div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        props:[
            'categoria', 'autenticado'
        ],  
        data() {
            return {
                documentos: []
            }
        },  
        methods:{
            listarDocumentos(){
                let me=this;
                axios.get('/documentos/busqueda/' + this.categoria.id).then(function (response) {
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
