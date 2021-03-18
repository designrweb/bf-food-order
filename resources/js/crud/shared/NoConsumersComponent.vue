<template>
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <div>Keine Verbraucher. Bitte erstellen</div>

            <a :href="main_route + '/create'" class="btn btn-success mt-2">+ Kunde Erstellen</a>
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