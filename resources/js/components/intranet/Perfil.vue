<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Mi cuenta</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                    </div>
                </b-col>
            </b-row>

            <perfil_usuario :usuario_id="usuario_id" :tipo_usuario_logeado="tipo_usuario_logeado"></perfil_usuario>

        </b-container>

    </div>
</template>

<script>
    export default {
        props: [
            'usuario_id', 'tipo_usuario_logeado'
        ]
    }
</script>

