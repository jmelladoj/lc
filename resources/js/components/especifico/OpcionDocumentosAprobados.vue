<template>
    <li @click="actualizar_datos"><a href="javascript:void(0)">Aprobados</a></li>
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
                Evento.$emit('listar_documentos')
            }
        }
    }
</script>
