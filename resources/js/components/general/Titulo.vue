<template>
    <section class="breadcrumb">
        <div class="breadcrumb-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">{{ titulo }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            'titulo'
        ]
    }
</script>
