<template>
  <div>
    <span class="summary">Showing <b>{{ firstItem ? firstItem : 0 }}-{{ lastItems ? lastItems : 0 }}</b> of <b>{{ totalItems }}</b> items.</span>
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
