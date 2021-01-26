<template>
  <a :class="[isIcon ? 'btn btn-sm btn-info m-1' : 'btn btn-info m-1']" :href="mainRoute+'/'+id+'/replicate'">
    <b-icon icon="files" v-if="isIcon"></b-icon>
    <span v-else>Copy</span>
  </a>
</template>
<script>
export default {
  name:  "CopyButton",
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
