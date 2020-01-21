<template>
    <li @click="actualizar_datos"><a href="javascript:void(0)">Documentos pendientes</a></li>
</template>

<script>


    export default {
        data() {
            return {

            }
        },    
        methods:{
            actualizar_datos(){
                this.$root.menu = 2
                Evento.$emit('listar_documentos')
            }
        }
    }
</script>