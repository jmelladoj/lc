<template>
    <b-row v-if="validationErrors" class="justify-content-around">
        <b-col>
            <b-alert variant="danger" show>
                <ul>
                    <li v-for="(value, key, index) in validationErrors" :key="index">{{ value }}</li>
                </ul>
            </b-alert>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        props: ['errors', 'campo'],
        data(){
            return {

            }
        },
        computed: {
            validationErrors(){
                if(this.campo != undefined){
                    let errors = Object.values(this.errors[this.campo]);
                    errors = errors.flat();
                    return errors;
                }
            }
        }
    }
</script>
