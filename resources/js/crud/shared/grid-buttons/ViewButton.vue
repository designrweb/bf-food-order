<template>
    <a class="btn btn-sm btn-primary m-1" :href="mainRoute+'/'+id">
        <b-icon icon="eye-fill"></b-icon>
    </a>
</template>
<script>
    export default {
        name:  "ViewButton",
        props: {
            mainRoute: String,
            id:        String|Number,
        }
    }
</script>

<style scoped>

</style>
