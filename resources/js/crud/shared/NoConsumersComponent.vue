<template>
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <div>Bislang sind keine Kinder angelegt.</div>

            <a :href="main_route + '/create'" class="btn btn-success mt-2">+ Kind anlegen</a>
        </div>
    </div>
</template>

<script>
export default {
    name: "NoConsumersComponent",
    props: {
        main_route: String
    }
}
</script>

<style scoped>

</style>