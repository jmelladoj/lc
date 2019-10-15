 <template>   
    <section id="intro" class="intro">
        <div class="item height-400px sm-height-400px" v-for="(slider, index) in sliders" :key="index">
            <div class="background-image div-img" data-background="storage/sliders/1-1.jpg" data-bg-posx="center" data-bg-posy="top" data-bg-overlay="6"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="intro-caption intro-caption-middel text-center intro-caption-fade sec-padding--lg">
                            <h1 class="intro-title" v-text="slider.texto"></h1>
                            <a :href="slider.link" class="btn btn--primary space--1" v-if="slider.link != ''">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
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
