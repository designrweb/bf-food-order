<template>
  <a :class="[isIcon ? 'btn btn-sm btn-warning m-1' : 'btn btn-warning m-1']" :href="mainRoute+'/'+id+'/edit'">
    <b-icon icon="pencil-fill" v-if="isIcon"></b-icon>
    <span v-else>Update</span>
  </a>
</template>
<script>
export default {
  name:  "EditButton",
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
