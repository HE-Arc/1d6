<template>
<span class="list-item">
    <slot></slot>
    <a v-bind:class="{'is-active' : cannotDelete}" href="#" class="delete-item" v-on:click="deleteEntry()">
    <i v-if="!cannotDelete" class="fa fa-trash"></i>
    </a>
</span>
</template>

<script>
export default {
  components: {},
  props: ["name", "cannotDelete"],
  methods: {
    deleteEntry() {
      let items = this.$parent.items;
      let index = items.indexOf(this.$slots.default[0].text);
      items.splice(index, 1);
    },
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
