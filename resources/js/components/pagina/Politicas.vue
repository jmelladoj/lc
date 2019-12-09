<template>
    <pdf :src="'/storage/general/terminos.pdf'"></pdf>
</template>

<script>
    import pdf from 'vue-pdf-cdn'

    export default {
        components: {  
            pdf
        }
    }
</script>