<template>
    <section id="intro" class="intro" v-show="sliders.length > 0">
        <b-carousel  :interval="4000" controls indicators background="rgba(0,0,0,0.6)" img-width="" img-height="400" style="text-shadow: 1px 1px 2px #333;">

            <b-carousel-slide v-for="(slider, index) in sliders" :key="index" :img-src="'storage/' + slider.url_imagen">
                <h2 class="intro-title" v-text="slider.texto" :style="'color:' + slider.color"></h2>
                <a :href="slider.link" class="btn btn--primary space--1 btn-sm" v-if="slider.link != ''">Ver más</a>
            </b-carousel-slide>
            
        </b-carousel>
    </section>   
</template>

<script>
    export default {
        props:[
            'ubicacion'
        ],  
        data() {
            return {
                sliders: []
            }
        },  
        methods:{
            listarSlider(){
                let me=this;
                axios.get('/sliders/ubicacion/' + this.ubicacion).then(function (response) {
                    me.sliders = response.data.sliders;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarSlider();
        }
    }
</script>
