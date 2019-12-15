<template>
  <span>
    <label class="label">
      <slot />
    </label>
    <div class="list is-hoverable item-list">
      <list-item
        v-for="item in items"
        v-bind:key="item.index"
        :read-only="readOnly"
        :initialRating="item.rating / 2"
        :save-function="saveFunction(item)"
      >{{ item.name }} {{item.rating / 2}}</list-item>
    </div>
  </span>
</template>

<script>
import listItem from "./list-item";

export default {
  components: {
    listItem
  },
  props: ["icon", "placeholder", "readOnly"],
  data: () => {
    return {
      items: [],
    };
  },
  methods: {
    saveFunction: function(item) {
      return (rating) => {
        item.rating = rating * 2; // plugin uses values [0, 5]
      };
    }
  }
};
</script>

<style scoped>
.item-list {
  max-height: calc(450px);
  overflow: auto;
}
.input-group-name {
  margin-bottom: 20px;
  width: auto;
}
</style>
