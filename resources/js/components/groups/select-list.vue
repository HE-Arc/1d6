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
        >{{ item }}</list-item>
        <list-item v-for="item in items" v-bind:key="item.index">{{ item.name }}</list-item>
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
  props: ["icon", "placeholder", "content-type"],
  data() {
    return {
      currentValue: "",
      unremovableItems: [],
      items: []
    };
  },
  methods: {
    addToList() {
      if (
        !this.items.includes(this.currentValue) &&
        itemExists[this.$props.contentType](this.currentValue)
      ) {
        if (this.contentType === "users") {

        } else if (this.contentType === "items") {

        }
        this.items.push(this.currentValue);
        // TODO: add item to DB using the API
      }
      this.currentValue = "";
    }
  }
};

let itemExists = {
  users: function(username) {
    let user = null;
    this.axios
      .get(this.axios.defaults.baseURL + "/users", {
        name: username
      })
      .then(function(response) {
        return true;
      })
      .catch(function(error) {
        return false;
      });
  },
  items: function(itemname) {
    return true;
  }
};
</script>

<style scoped>
.input-group-name {
  margin-bottom: 20px;
  width: auto;
}
</style>
