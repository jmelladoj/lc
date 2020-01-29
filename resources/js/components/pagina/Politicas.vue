<template>
    <b-row>
        <pdf v-for="i in numPages" :key="i" :src="src" :page="i" style="display: inline-block; width: 100%" ></pdf>
    </b-row>
</template>

<script>
    import babel from 'babel-runtime/regenerator'
    import pdf from 'vue-pdf'

    let pdfDocument = pdf.createLoadingTask('/storage/general/terminos.pdf');

    export default {
        components: {
            babel,
            pdf
        },
        data(){
            return {
                src: pdfDocument,
                numPages: 0
            }
        },
        mounted() {
            this.src.then(pdf => {
                this.numPages = pdf.numPages;
            })
        }
    }
</script>
