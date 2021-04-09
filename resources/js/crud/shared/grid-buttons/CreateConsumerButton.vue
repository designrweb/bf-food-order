<template>
    <a :class="[isCompletedProfile ? 'btn btn-success ' : 'btn btn-outline-secondary disabled '] + classes"
       :href="mainRoute">
        {{ label }}
    </a>
</template>
<script>
export default {
    name:     "CreateConsumerButton",
    props:    {
        mainRoute: String,
        label:     String,
        classes:   String,
    },
    computed: {
        isCompletedProfile: function () {
            return document.querySelector('meta[name="is-completed-profile"]').getAttribute('content');
        }
    },
}
</script>

<style scoped>
a {
    justify-content: center;
    align-items: center;
}
</style>
