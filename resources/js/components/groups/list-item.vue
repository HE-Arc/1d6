<template>
  <span class="list-item">
    <slot />
    <a href="#" v-if="!cannotDelete" class="delete-item" v-on:click="removeFunction">
      <i class="fa fa-trash"></i>
    </a>
  </span>
</template>

<script>
export default {
  components: {},
  props: ["cannotDelete", "remove-function"],
};
</script>

<style scoped>
.delete-item {
  margin-right: 12px;
  float: right;
}
</style>
