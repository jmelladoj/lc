<template>

</template>
<script>
    export default {
        methods:{
            solicitarAsesoria(){
                Swal.fire({
                    title: '¿Deseas solicitar una asesoría?',
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
                        axios.post('/solicitar/asesoria').then(function (response) {

                        	Vue.$toast.open({
		                        message: response.data.mensaje,
		                        type: response.data.clase,
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
            this.solicitarAsesoria();
        }
    }
</script>