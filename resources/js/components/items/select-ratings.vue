<template>
  <span>
    <label class="label">
      <slot />
    </label>
    <div class="list is-hoverable item-list">
      <list-item v-for="item in items" v-bind:key="item.index" :stars="item.stars">{{ item.name }}</list-item>
    </div>
  </span>
</template>

<script>
import listItem from "./list-item";

export default {
  components: {
    listItem
  },
  props: ["icon", "placeholder"],
  data: () => {
    return {
      items: [
        { name: "EatEco - Best burger in Neuchatel", stars: 5 },
        { name: "King Food", stars: 3 },
        { name: "Coop", stars: 4 },
        { name: "Bleu", stars: 5 },
        { name: "Piadina", stars: 5 },
        { name: "McDonald", stars: 1 },
        { name: "EatEco - Best burger in Neuchatel", stars: 5 },
        { name: "King Food", stars: 3 },
        { name: "Coop", stars: 4 },
        { name: "Bleu", stars: 5 },
        { name: "Piadina", stars: 5 },
        { name: "McDonald", stars: 1 },
      ]
    };
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
