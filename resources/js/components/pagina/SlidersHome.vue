 <template>   
    <section id="intro" class="intro" v-show="sliders.length > 0">
        <b-carousel  :interval="4000" controls indicators background="rgba(0,0,0,0.6)" img-width="" img-height="600" style="text-shadow: 1px 1px 2px #333;">

            <b-carousel-slide v-for="(slider, index) in sliders" :key="index" img-src="https://picsum.photos/1024/480/?image=52">
                <h2 class="intro-title" v-text="slider.texto" :style="'color:' + slider.color"></h2>
                <a :href="slider.link" class="btn btn--primary space--1 btn-sm" v-if="slider.link != ''">Ver más</a>
            </b-carousel-slide>
            
        </b-carousel>
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
    .carousel-caption {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 10;
        padding-top: 250px;
        padding-bottom: 20px;
        text-align: center;
        top: 0;
        background-color:rgba(0,0,0,0.4);
    }

    .img-fluid{
        height: 600px;
    }

</style>