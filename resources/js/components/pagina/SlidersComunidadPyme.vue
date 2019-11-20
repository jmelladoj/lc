<template>
    <section id="intro" class="intro mb-5">
        <div class="item height-400px sm-height-400px">
            <div class="item height-400px sm-height-400px">
                <b-carousel v-if="tipo_persona == undefined"  :interval="4000" controls indicators background="rgba(0,0,0,0.6)" img-width="" img-height="200" style="text-shadow: 1px 1px 2px #333;">
                    <b-carousel-slide :img-src="'https://i1.wp.com/www.practicallysane.net/wp-content/uploads/2019/01/work.jpg?fit=1950%2C1300&ssl=1'">
                        <h2 class="intro-title" v-text="'¿Quieres ser parte de nuestra comunidad Pyme?'" style="color: #fff"></h2>
                        <a href="/login" class="btn btn--primary space--1 btn-sm">Ver más</a>
                    </b-carousel-slide>
                </b-carousel>

                <b-carousel v-else-if="tipo_persona == 2"  :interval="4000" controls indicators background="rgba(0,0,0,0.6)" img-width="" img-height="200" style="text-shadow: 1px 1px 2px #333;">

                    <b-carousel-slide v-for="(slider, index) in sliders_no_logeado" :key="index" :img-src="'https://i1.wp.com/www.practicallysane.net/wp-content/uploads/2019/01/work.jpg?fit=1950%2C1300&ssl=1'">
                        <h2 class="intro-title"  v-text="slider.texto" style="color: #fff"></h2>
                        <a href="#" class="btn btn--primary space--1 btn-sm" v-text="slider.boton"></a>
                    </b-carousel-slide>
                </b-carousel>
            </div>
        </div>
    </section>   
</template>

<script>
    export default {
        props: [
            'tipo_persona'
        ],
        data() {
            return {
                sliders_no_logeado: null
            }
        },  
        mounted() {
            this.sliders_no_logeado = [
                {
                    boton: 'Ver más',
                    texto: '¿Quieres ser parte de nuestra comunidad Pyme?'
                },
                {
                    boton: '¿Cómo ser parte de la comunidad Pyme?',
                    texto: '¡Comienza aquí!'
                },
                {
                    boton: '¿Cómo llegar al Top five en la comunidad Pyme?',
                    texto: '¡Descúbrelo aquí!'
                },
                {
                    boton: '¿Cómo destacar tu Pyme?',
                    texto: '¡Destácate aquí!'
                }
            ]
        }
    }
</script>
