<template>
    <b-row v-if="validationErrors" class="justify-content-around">
        <b-alert variant="danger" show>
            <ul>
                <li v-for="(value, key, index) in validationErrors" :key="index">{{ value }}</li>
            </ul>
        </b-alert>
    </b-row>
</template>

<script>
    export default {
        props: ['errors'],
        data(){
            return {

            }
        },
        computed: {
            validationErrors(){
                let errors = Object.values(this.errors);
                errors = errors.flat();
                return errors;
            }
        }
    }
</script>