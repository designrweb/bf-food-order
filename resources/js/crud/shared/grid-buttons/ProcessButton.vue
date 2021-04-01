<template>
  <a :class="[isIcon ? 'btn btn-sm btn-success m-1' : 'btn btn-success m-1']"
     :href="mainRoute+'/'+id+'/process'">
    <b-icon icon="play-fill" v-if="isIcon"></b-icon>
    <span v-else>Process</span>
  </a>
</template>
<script>
export default {
  name:  "ProcessButton",
  props: {
    mainRoute: String,
    isIcon:    {
      type:    Boolean,
      default: true
    },
    id:        String | Number,
  }
}
</script>

<style scoped>
.btn-warning {
  color: white;
}
</style>
