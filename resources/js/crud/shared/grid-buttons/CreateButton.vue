<template>
    <a class="btn btn-success float-right" :href="mainRoute+'/create'">
        <b-icon icon="plus" font-scale="1.5"></b-icon>
        Create</a>
</template>
<script>
    export default {
        name:  "CreateButton",
        props: {
            mainRoute: String,
        }
    }
</script>

<style scoped>
    a {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
