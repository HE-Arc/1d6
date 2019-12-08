<template>
  <default-layout>
    <modal ref="modal">
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
  methods: {
    createGroup: function() {
      this.currentGroup.name = "";
      this.currentGroup.users = [];
      this.currentGroup.items = [];

      this.$refs.modal.title = "Create a new group";
      this.$refs.modal.saveText = "Create";
      this.$refs.modal.saveFunction = this.addGroup;

      this.populateAndDisplayModal();
    },
    editGroup: function(id) {
      // TODO: get group from API using id
      // this.currentGroup = ...
      // remove self from the list so that it doesn't appear twice

      this.$refs.modal.title = "Edit group";
      this.$refs.modal.saveText = "Save";
      this.$refs.modal.saveFunction = this.saveGroup;

      this.populateAndDisplayModal();
    },
    populateAndDisplayModal: function() {
      this.$refs["group-name"] = this.currentGroup.name;
      this.$refs["group-users"].unremovableItems = ["You"];
      this.$refs["group-users"].items = this.currentGroup.users;
      this.$refs["group-items"].items = this.currentGroup.items;

      this.$refs.modal.active = true;
    },
    addGroup: function() {
      this.currentGroup.users = this.currentGroup.users.map(username => {
        return { name: username, admin: false };
      });
      this.currentGroup.users.push({
        name: localStorage.getItem("username"),
        amdin: true
      });

      // TODO: send this.currentGroup to the API
      console.log(this.currentGroup);
    },
    saveGroup: function() {
      // TODO
    }
  },
  mounted: function() {
    // TODO: get all groups from the user from the API
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
