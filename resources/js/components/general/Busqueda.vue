<template>
    <li class="nav-item">
        <span class="mt-1 app-search d-none d-md-block d-lg-block">
            <input v-model="busqueda" type="text" class="form-control" placeholder="Búsqueda de contenido" @keyup.enter="realizar_busqueda">
        </span>
    </li>
</template>


<script>
    export default {
        data() {
            return {
                busqueda: ''
            }
        },
        methods:{
            realizar_busqueda(){
                this.$root.menu = 13
                Evento.$emit('listar_documentos', this.busqueda)
                this.busqueda = ''
            },
        },
        mounted() {

        }
    }
</script>
