<template>
    <section id="intro" class="intro" v-show="sliders.length > 0">
        <div class="item height-400px sm-height-400px">
            <b-carousel  :interval="4000" controls indicators background="rgba(0,0,0,0.6)" img-width="" img-height="200" style="text-shadow: 1px 1px 2px #333;">

                <b-carousel-slide v-for="(slider, index) in sliders" :key="index" :img-src="'storage/' + slider.url_imagen">
                    <h2 class="intro-title" :class="slider.alineacion_titulo" v-text="slider.texto" :style="'color:' + slider.color + ';' + 'font-size:' + slider.letra_titulo + 'px;'"></h2>
                    <h4 v-if="slider.subtexto != ''" :class="slider.alineacion_sub_titulo" :style="'color:' + slider.subcolor + ';' + 'font-size:' + slider.letra_sub_titulo + 'px;'" v-text="slider.subtexto"></h4>
                    <button class="btn btn--primary space--1 btn-sm" @click="redireccion(slider.link)" v-show="slider.link != '/intranet/0'">Ver más</button>
                    <a class="btn btn--primary space--1 btn-sm" :href="slider.link_alternativo_uno" v-show="slider.link_alternativo_uno != null" target="_blank">Ir al enlace</a>
                    <a class="btn btn--primary space--1 btn-sm" :href="slider.link_alternativo_dos" v-show="slider.link_alternativo_dos != null" target="_blank">Ir al enlace</a>
                </b-carousel-slide>

            </b-carousel>
        </div>
    </section>
</template>

<script>
    export default {
        props:[
            'ubicacion', 'usuario'
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
            },
            redireccion(link){
                var tmp = link.split("");
                var map = tmp.map(function(current) {
                    if (!isNaN(parseInt(current))) {
                    return current;
                    }
                });

                var numbers = map.filter(function(value) {
                    return value != undefined;
                });

                window.location.href = "/intranet/" + numbers.join("")

            }
        },
        mounted() {
            this.listarSlider();
        }
    }
</script>
