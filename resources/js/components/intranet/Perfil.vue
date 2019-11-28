<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Mi cuenta</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                    </div>                    
                </b-col>
            </b-row>


            <b-form-group v-if="mensaje != 'sin mensaje'">
                <b-col>
                    <b-alert variant="warning" show v-text="mensaje">{{ mensaje }}</b-alert>
                </b-col>
            </b-form-group>

            <perfil_usuario :usuario_id="usuario_id" :tipo_usuario_logeado="tipo_usuario_logeado"></perfil_usuario>

        </b-container>

    </div>
</template>

<script>
    export default {
        props: [
            'usuario_id', 'tipo_usuario_logeado', 'mensaje'
        ]
    }
</script>

