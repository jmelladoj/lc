<template>
    <section class="sec-padding-login" v-show="documentos.length > 0">
        <div class="container">
            <div class="page-head">
                <span class="page-sub-title"></span>
                <h2 class="page-title" v-text="titulo"></h2>
            </div>
        </div>
        <div class="container">
            <carousel :per-page="6" :autoplay="true" :navigationEnabled="true" :loop="true" paginationActiveColor="#8ab733" :centerMode="true">
                <slide v-for="(documento, index) in documentos" :key="index">
                    <div class="product-item ml-2 mr-2">
                        <ver-documento :documento="documento" :autenticado="autenticado"></ver-documento>
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
