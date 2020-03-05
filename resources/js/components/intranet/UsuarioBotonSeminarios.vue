<template>
    <li v-show="items.length > 0" @click="$root.menu=6">
        <a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-calendar"></i><span class="hide-menu"> Seminarios</span></a>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                items: []
            }
        },
        methods:{
            listarPromociones (){
                let me=this;
                axios.get('/seminarios/2').then(function (response) {
                    me.items = response.data.seminarios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        },
        mounted() {
            this.listarPromociones();
        }
    }
</script>
