<template> 
    <section class="sec-padding">
        <div class="container">
            <carousel :per-page="6" :autoplay="true" :paginationActiveColor="'#8ab733'" :loop="true">
                <slide v-for="(sitio, index) in sitios" :key="index">
                    <div class="brand-item">
                        <a :href="sitio.link" target="_blank">
                            <img v-bind:src="'storage/' + sitio.url_imagen" alt="brand" />
                        </a>
                    </div>
                </slide>
            </carousel>
        </div>
    </section>
</template>

<script>
    export default {  
        data() {
            return {
                sitios: []
            }
        },  
        methods:{
            listar_sitios(){
                let me=this;
                axios.get('/sitios').then(function (response) {
                    me.sitios = response.data.sitios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listar_sitios();
        }
    }
</script>