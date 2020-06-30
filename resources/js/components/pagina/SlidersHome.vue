 <template>
    <section id="intro" class="intro" v-if="sliders.length > 0">
        <div class="item height-400px sm-height-400px">
            <b-carousel  :interval="5000" controls indicators background="rgba(232, 236, 209, 0.6)" img-width="" img-height="200" style="text-shadow: 1px 1px 2px #333;">

                <b-carousel-slide v-for="(slider, index) in sliders" :key="index" :img-src="'storage/' + slider.url_imagen">
                    <h2 class="intro-title" :class="slider.alineacion_titulo" v-text="slider.texto" :style="'color:' + slider.color + ';' + 'font-size:' + slider.letra_titulo + 'px; -webkit-text-stroke:' + slider.texto_borde_externo + 'px black; background-color: ' + slider.texto_color_fondo + ';'"></h2>
                    <h4 v-if="slider.subtexto != ''" :class="slider.alineacion_sub_titulo" :style="'color:' + slider.subcolor + ';' + 'font-size:' + slider.letra_sub_titulo + 'px; -webkit-text-stroke:' + slider.subtitulo_borde_externo + 'px black; background-color: ' + slider.subtitulo_color_fondo + ';'" v-text="slider.subtexto"></h4>
                    <h4 v-if="slider.parrafo != ''" :class="slider.alineacion_parrafo" :style="'color:' + slider.parrafo_color + ';' + 'font-size:' + slider.letra_parrafo + 'px; -webkit-text-stroke:' + slider.parrafo_borde_externo + 'px black; background-color: ' + slider.parrafo_color_fondo + ';'" v-text="slider.parrafo"></h4>
                    <button class="btn btn--primary space--1 btn-sm boton_redondo" @click="redireccion(slider.link)" v-show="slider.link != '/intranet/0'">Ver más</button>
                    <a class="btn btn--primary space--1 btn-sm boton_redondo" :href="slider.link_alternativo_uno" v-show="slider.link_alternativo_uno != null" target="_blank">Ver más</a>
                    <a class="btn btn--primary space--1 btn-sm boton_redondo" :href="slider.link_alternativo_dos" v-show="slider.link_alternativo_dos != null" target="_blank">Ver más</a>
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
                    me.sliders = response.data.sliders;

                    if(me.usuario){
                        if(me.usuario.tipo_usuario == 3){
                            me.sliders = me.sliders.filter(function(item){
                                if(me.usuario != undefined){
                                    return item.tipo_persona == null || parseInt(item.tipo_persona) == me.usuario.tipo_persona;
                                } else {
                                    return item.tipo_persona == null;
                                }
                            })
                        }
                    } else {
                        me.sliders = me.sliders.filter(function(item){
                            return item.tipo_persona == null;
                        })
                    }

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
        right: 20%;
        left: 20%;
        z-index: 10;
        text-align: center;
        top: 50%;
        transform: translateY(-50%);
        bottom: initial;
    }

    .carousel-item {
        max-height: 400px;
    }

    .img-fluid{
        height: 400px;
        object-fit: cover;
    }

    .carousel {
        height: 400px;
    }
</style>
