<template>
    <section class="sec-padding" v-show="categorias.length > 0">
        <div class="container">
            <div class="page-head">
                <span class="page-sub-title"></span>
                <h2 class="page-title">Documentos preferidos de la comunidad</h2>
            </div>
        </div>
        <div class="container">
            <b-row class="justify-content-md-center">
                <b-col cols="3" class="mb-2" v-for="(categoria, index) in categorias" :key="index">
                    <a v-bind:href="'/busqueda/' + categoria.id" class="redondear btn btn--primary space--button btn-block" v-text="categoria.nombre"></a>
                </b-col>
            </b-row>
        </div>
    </section>
</template>

<script>
    export default {  
        data() {
            return {
                categorias: []
            }
        },  
        methods:{
            listarCategorias(){
                let me=this;
                axios.get('/categorias/home').then(function (response) {
                    me.categorias = response.data.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarCategorias();
        }
    }
</script>