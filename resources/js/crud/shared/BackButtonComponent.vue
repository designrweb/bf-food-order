<template>
    <div class="row row mb-2 pb-2 pt-2">
        <div class="col-12">
            <a :href="route" class="sortable">
                <b-icon icon="arrow-left-square-fill" font-scale="1.5"></b-icon>
                &nbsp Go back</a>
        </div>
    </div>
</template>

<script>
    export default {
        name:  "BackButtonComponent",
        props: {
            route: String,
        },
    }
</script>

<style scoped>
    a:hover {
        text-decoration: none;
    }
</style>
