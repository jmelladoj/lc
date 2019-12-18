 <template>
    <section id="intro" class="intro" v-if="sliders.length > 0">
        <div class="item height-400px sm-height-400px">
            <b-carousel  :interval="4000" controls indicators background="rgba(0,0,0,0.6)" img-width="" img-height="600" style="text-shadow: 1px 1px 2px #333;">
                <b-carousel-slide v-for="(slider, index) in sliders" :key="index" :img-src="'storage/' + slider.url_imagen">
                    <h2 class="intro-title" v-text="slider.texto" :style="'color:' + slider.color"></h2>
                    <h4 v-if="slider.subtexto != ''" :style="'color:' + slider.subcolor" v-text="slider.subtexto"></h4>
                    <a v-show="slider.link.length > 0" :href="slider.link" class="btn btn--primary space--1 btn-sm">Ver más</a>
                </b-carousel-slide>
            </b-carousel>
        </div>

    </section>
</template>

<script>
    export default {
        props: [
            'usuario'
        ],
        data() {
            return {
                sliders: []
            }
        },
        methods:{
            listarSlidersHome(){
                let me=this;
                axios.get('/sliders/home').then(function (response) {
                    me.sliders = response.data.sliders

                    me.sliders = me.sliders.filter(function(item){
                        if(me.usuario != undefined){
                            return item.tipo_persona == null || parseInt(item.tipo_persona) == me.usuario.tipo_persona;
                        } else {
                            return item.tipo_persona == null;
                        }

                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarSlidersHome();
        }
    }
</script>

<style>
    .carousel-caption {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 10;
        padding-top: 5%;
        padding-bottom: 20px;
        text-align: center;
        top: 0;
    }

    .img-fluid{
        height: 600px;
    }

    .carousel {
        height: 400px;
    }
</style>
