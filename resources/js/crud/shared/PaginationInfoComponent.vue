<template>
    <div>
        <span class="info-text">Showing <b>{{ firstItem }}-{{ lastItems }}</b> of <b>{{ totalItems }}</b> items.</span>
    </div>
</template>

<script>
export default {
    props: {
        firstItem:  Number,
        lastItems:  Number,
        totalItems: Number,
    },
};
</script>

<style scoped>
.info-text {
    font-size: 12px;
}
</style>
