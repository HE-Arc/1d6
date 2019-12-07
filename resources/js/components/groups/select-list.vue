<template>
  <span>
    <label class="label"><slot /></label>
    <div class="list is-hoverable group-item-list">
      <list-item v-for="item in items" v-bind:key="item.index">
        {{ item }}
      </list-item>
    </div>
    <div class="field has-addons">
      <div class="control is-expanded">
        <input type="text" :placeholder="placeholder" class="input" />
      </div>
      <div class="control">
        <button type="submit" class="button is-primary">
          <i class="fa" :class="icon"></i>
        </button>
      </div>
    </div>
  </span>
</template>

<script>
import listItem from './list-item';

export default {
  components: {
    listItem
  },
  props: [
      "icon", "placeholder"
  ], data: () => {
    return {
      items: ["Bleu", "King Food", "Coop"]
    }
  }
};
</script>

<style>
.input-group-name {
  margin-bottom: 20px;
  width: auto;
}
</style>
