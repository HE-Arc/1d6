<template>
  <default-layout>
    <modal
      title="Create a new group"
      save-text="Create group"
      :save-function="addGroup"
      ref="modal"
    >
            <label class="label">Group name</label>
      <input
        type="text"
        placeholder="Where are we gonna eat ?"
        class="input input-group-name"
        v-model="currentGroup.name"
      />
            <div class="columns">
              <div class="column is-half">
          <select-list
            icon="fa-user-plus"
            placeholder="Member name"
            content-type="users"
            ref="group-users"
          >Members</select-list>
              </div>
              <div class="column is-half">
          <select-list
            icon="fa-plus"
            placeholder="Item name"
            content-type="items"
            ref="group-items"
          >Default items</select-list>
              </div>
            </div>
    </modal>
    <h1>Your groups</h1>
    <div
      class="columns is-multiline is-1-mobile is-0-tablet is-3-desktop is-8-widescreen container-container"
    >
      <group-card v-for="group in groups" v-bind:key="group.index" v-bind:group="group"></group-card>
      </div>
    <button class="button is-primary is-rounded floating-button" v-on:click="createGroup">New group</button>
  </default-layout>
</template>

<script>
import modal from "../modal";
import selectList from "../groups/select-list";
import groupCard from "../groups/group-card";

export default {
  components: {
    modal,
    selectList,
    groupCard
  },
  data() {
    return {
      currentGroup: {
        name: "",
        users: [],
        items: []
      },
      groups: []
    };
  },
  }
};
</script>

<style>
.input-group-name {
  margin-bottom: 20px;
  width: auto;
}

.group-item-list {
  max-height: 200px;
  overflow: auto;
}

.delete-item {
  margin-right: 12px;
  float: right;
}
</style>
