<template>
    <section v-show="sliders.length > 0 && tipo_persona != undefined && tipo_persona == 2 || tipo_usuario < 3" id="intro" class="intro">
        <div class="item height-400px sm-height-400px">
            <div class="item height-400px sm-height-400px">
                <b-carousel v-if="tipo_persona == undefined"  :interval="4000" controls indicators background="rgba(0,0,0,0.6)" img-width="" img-height="200" style="text-shadow: 1px 1px 2px #333;">
                    <b-carousel-slide :img-src="'https://i1.wp.com/www.practicallysane.net/wp-content/uploads/2019/01/work.jpg?fit=1950%2C1300&ssl=1'">
                        <h2 class="intro-title" v-text="'¿Quieres ser parte de nuestra comunidad Pyme?'" style="color: #fff"></h2>
                        <a href="/login" class="btn btn--primary space--1 btn-sm">Ver más</a>
                    </b-carousel-slide>
                </b-carousel>

                <b-carousel v-else-if="tipo_persona == 2 || tipo_usuario < 3"  :interval="4000" controls indicators background="rgba(0,0,0,0.6)" img-width="" img-height="200" style="text-shadow: 1px 1px 2px #333;">
                    <b-carousel-slide v-for="(slider, index) in sliders" :key="index" :img-src="'storage/' + slider.url_imagen">
                        <h2 class="intro-title" :class="slider.alineacion_titulo" v-text="slider.texto" :style="'color:' + slider.color + ';' + 'font-size:' + slider.letra_titulo + 'px;'"></h2>
                        <h4 v-if="slider.subtexto != ''" :class="slider.alineacion_sub_titulo" :style="'color:' + slider.subcolor + ';' + 'font-size:' + slider.letra_sub_titulo + 'px;'" v-text="slider.subtexto"></h4>
                        <button class="btn btn--primary space--1 btn-sm" @click="redireccion(slider.link)" v-show="slider.link != '/intranet/0'">Ver más</button>
                        <a class="btn btn--primary space--1 btn-sm" :href="slider.link_alternativo_uno" v-show="slider.link_alternativo_uno != ''" target="_blank">Ir al enlace</a>
                        <a class="btn btn--primary space--1 btn-sm" :href="slider.link_alternativo_dos" v-show="slider.link_alternativo_dos != ''" target="_blank">Ir al enlace</a>
                    </b-carousel-slide>
                </b-carousel>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            'tipo_persona', 'tipo_usuario'
        ],
        data() {
            return {
                sliders: []
            }
        },
        methods: {
            listarSliders (){
                let me=this;
                axios.get('/sliders/comunidad/home').then(function (response) {
                    me.sliders = response.data.sliders;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            realizarConsulta(titulo, ruta){
                Swal.fire({
                    title: titulo,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8AB733',
                    cancelButtonColor: '#d7552a',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.post('/pagina/comunidad/alerta',{
                            'mensaje': titulo
                        }).then(function (response) {
                            me.listarSliders();

                            Vue.$toast.open({
		                        message: '!Felicitaciones¡, pronto serás contactado por Prevención LebenCo.',
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            }
        },
        mounted() {
            this.listarSliders();
        }
    }
</script>

<style>
    .swal2-styled:focus {
        outline: 0;
        box-shadow: none;
    }
</style>
