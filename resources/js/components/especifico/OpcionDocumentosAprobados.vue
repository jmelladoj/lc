<template>
    <li @click="actualizar_datos"><a href="javascript:void(0)">Documentos aprobados</a></li>
</template>

<script>


    export default {
        data() {
            return {

            }
        },    
        methods:{
            actualizar_datos(){
                this.$root.menu = 1
                Event.$emit('listar_documentos')
            }
        }
    }
</script>