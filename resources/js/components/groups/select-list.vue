<template>
  <form v-on:submit.prevent="addToList">
    <span>
      <label class="label">
        <slot />
      </label>
      <div class="list is-hoverable group-item-list">
        <list-item
          cannot-delete="cannot-delete"
          v-for="item in unremovableItems"
          v-bind:key="item.index"
        >{{ item.name }}</list-item>
        <list-item
          v-for="item in items"
          v-bind:key="item.id"
          :remove-function="removeFromList(item)"
        >{{ item.name }}</list-item>
      </div>
      <div class="field has-addons">
        <div class="control is-expanded">
          <input type="text" :placeholder="placeholder" class="input" v-model="currentValue" />
        </div>
        <div class="control">
          <button class="button is-primary" v-bind:disabled="currentValue.length === 0">
            <i class="fa" :class="icon"></i>
          </button>
        </div>
      </div>
    </span>
  </form>
</template>

<script>
import listItem from "./list-item";

export default {
  components: {
    listItem
  },
  props: ["icon", "placeholder", "items", "add-function", "remove-function"],
  data() {
    return {
      currentValue: "",
      unremovableItems: []
    };
  },
  methods: {
    addToList() {
      this.addFunction(this.currentValue);
      this.currentValue = "";
    },
    removeFromList(item) {
      return () => {
        this.removeFunction(item)
      }
    }
  }
};
</script>

<style scoped>
.group-item-list {
  max-height: 200px;
  overflow: auto;
}
</style>
