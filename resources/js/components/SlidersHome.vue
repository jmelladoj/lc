 <template>   
    <section id="intro" class="intro" v-show="sliders.length > 0">
        <div class="item height-600px sm-height-600px">
            <carousel :per-page="1" :autoplay="true">
                <slide  v-for="(slider, index) in sliders" :key="index"  :paginationActiveColor="'#3F8A24'">
                    <div class="background-image div-img" data-bg-posx="center" data-bg-posy="top" data-bg-overlay="6"></div>
                    <img v-bind:src="'storage/' + slider.url_imagen">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="intro-caption intro-caption-middel text-center intro-caption-fade sec-padding--lg">
                                    <h1 class="intro-title" v-text="slider.texto" :style="'color:' + slider.color"></h1>
                                    <a :href="slider.link" class="btn btn--primary space--1" v-if="slider.link != ''">Ver más</a>
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
    .background-image {
        background-color: transparent;
    }

    .intro-caption-middel{
        top: 25%;
    }
</style>