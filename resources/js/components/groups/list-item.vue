<template>
<span class="list-item">
    <slot></slot>
    <a class="delete-item">
    <i class="fa fa-trash"></i>
    </a>
</span>
</template>

<script>
export default {
  components: {},
  props: ["name"]
};
</script>

<style>

.group-item-list {
  max-height: 200px;
  overflow: auto;
}

.delete-item {
  margin-right: 12px;
  float: right;
}
</style>
