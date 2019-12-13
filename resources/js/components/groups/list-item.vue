<template>
  <span class="list-item">
    <slot />
    <a href="#" v-if="!cannotDelete" class="delete-item" v-on:click="deleteEntry()">
      <i class="fa fa-trash"></i>
    </a>
  </span>
</template>

<script>
export default {
  components: {},
  props: ["cannotDelete"],
  methods: {
    deleteEntry() {
      let items = this.$parent.items;
      let index = items.indexOf(this.$slots.default[0].text);
      items.splice(index, 1);
    }
  }
};
</script>

<style scoped>
.group-item-list {
  max-height: 200px;
  overflow: auto;
}

.delete-item {
  margin-right: 12px;
  float: right;
}
</style>
