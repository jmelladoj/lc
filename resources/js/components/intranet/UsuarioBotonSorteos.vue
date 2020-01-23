<template>
    <li v-show="items.length > 0" @click="$root.menu=3">
        <a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list-ol"></i><span class="hide-menu"> Sorteos</span></a>
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
                axios.get('/sorteos/2').then(function (response) {
                    me.items = response.data.promociones;
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
