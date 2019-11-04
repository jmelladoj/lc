<template>
    <section id="intro" class="intro mb-5">
        <div class="item height-400px sm-height-400px">
            <carousel :per-page="1" :autoplay="true"  :paginationActiveColor="'#3F8A24'">
                <slide v-show="tipo_persona == undefined" v-for="(slider, index) in sliders_no_logeado" :key="index">
                    <div class="background-image div-img" data-bg-posx="center" data-bg-posy="top" data-bg-overlay="6"></div>
                    <img src="https://i1.wp.com/www.practicallysane.net/wp-content/uploads/2019/01/work.jpg?fit=1950%2C1300&ssl=1">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="intro-caption text-center intro-caption-fade sec-padding--lg">
                                    <h1 class="intro-title" v-text="slider.texto" :style="'color: #fff'"></h1>
                                    <a :href="'/login'" class="btn btn--primary space--1" v-text="slider.boton"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </slide>
            </carousel>
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
                sliders_no_logeado: null,
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
