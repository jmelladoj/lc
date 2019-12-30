<template>
    <section v-show="sliders.length > 0 && tipo_persona != undefined && tipo_persona == 2 || tipo_usuario < 3" id="intro" class="intro mb-5">
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
                        <h2 class="intro-title"  v-text="slider.texto" style="color: #fff"></h2>
                        <h4 v-if="slider.subtexto != ''" :style="'color:' + slider.subcolor" v-text="slider.subtexto"></h4>
                        <a v-show="slider.link != '/intranet/0'" :href="slider.link" class="btn btn--primary space--1 btn-sm" v-text="slider.texto_boton"></a>
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
