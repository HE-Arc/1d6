<template>
  <default-layout>
    <modal ref="groupModal">
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
            ref="groupUsers"
          >Members</select-list>
        </div>
        <div class="column is-half">
          <select-list
            icon="fa-plus"
            placeholder="Item name"
            content-type="items"
            ref="groupItems"
          >Default items</select-list>
        </div>
      </div>
    </modal>

    <modal ref="ratingsModal">
      <div class="item-list">
        <select-ratings ref="ratingsList">Ratings</select-ratings>
      </div>
    </modal>

    <h1>Your groups</h1>
    <div
      class="columns is-multiline is-1-mobile is-0-tablet is-3-desktop is-8-widescreen container-container"
    >
      <group-card
        v-for="group in groups"
        v-bind:key="group.index"
        v-bind:group="group"
        :edit-function="editGroup"
        :delete-function="deleteGroup"
        :edit-ratings-function="editRatings"
      ></group-card>
    </div>
    <button class="button is-primary is-rounded floating-button" v-on:click="createGroup">New group</button>
  </default-layout>
</template>

<script>
import modal from "../modal";
import selectList from "../groups/select-list";
import groupCard from "../groups/group-card";
import selectRatings from "../items/select-ratings";

export default {
  components: {
    modal,
    selectList,
    groupCard,
    selectRatings
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
    populateAndDisplayGroupModal: function() {
      this.$refs.groupName = this.currentGroup.name;
      this.$refs.groupUsers.unremovableItems = [localStorage.getItem("username") + " (you)"];
      this.$refs.groupItems.items = this.currentGroup.items;
      this.$refs.groupUsers.items = this.currentGroup.users;

      this.$refs.groupModal.active = true;
    },
    createGroup: function() {
      this.currentGroup.name = "";
      this.currentGroup.users = [];
      this.currentGroup.items = [];

      this.$refs.groupModal.title = "Create a new group";
      this.$refs.groupModal.saveText = "Create";
      this.$refs.groupModal.saveFunction = this.addGroup;

      this.populateAndDisplayGroupModal();
    },
    editGroup: function(id) {
      // TODO: get group from API using id
      // this.currentGroup = this.axios.get(...)
      this.currentGroup = this.groups.find(group => group.id === id);
      this.currentGroup.users = this.currentGroup.users.map(user => user.name);

      // remove self from the list so that it doesn't appear twice
      this.currentGroup.users.splice(
        this.currentGroup.users.indexOf(localStorage.getItem("username")),
        1
      );

      this.$refs.groupModal.title = "Edit group";
      this.$refs.groupModal.saveText = "Save";
      this.$refs.groupModal.saveFunction = this.saveGroup;

      this.populateAndDisplayGroupModal();
    },
    editRatings: function(id) {
      // TODO: get default ratings from user for this group's items from API using id
      let defaultRatings = this.groups
        .find(group => group.id === id)
        .items.map(item => {
          return { name: item, rating: (Math.random() * 21) / 4 };
        });

      console.log(defaultRatings)

      this.$refs.ratingsList.items = defaultRatings;
      this.$refs.ratingsModal.title = "Edit your default ratings";
      this.$refs.ratingsModal.saveText = "Save";
      this.$refs.ratingsModal.saveFunction = () => {} // TODO

      this.$refs.ratingsModal.active = true;
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
      this.groups.push(this.currentGroup);
      // console.log(this.currentGroup);
    },
    saveGroup: function() {
      this.currentGroup.users = this.currentGroup.users.map(username => {
        return { name: username, admin: false };
      });
      this.currentGroup.users.push({
        name: localStorage.getItem("username"),
        amdin: true
      });

      // TODO: patch the currentGroup via API
    },
    deleteGroup: function(id) {
      // TODO: delete from DB via API
      this.groups.splice(this.groups.findIndex(group => group.id === id), 1);
    }
  },
  mounted: function() {
    // TODO: get all groups from the user from the API
    this.groups.push({
      name: "Groupe A",
      users: [{ name: "1d6", admin: true }, { name: "Patrick", admin: false }],
      items: ["paprika", "parpika"],
      id: 1
    });
    this.groups.push({
      name: "Groupe B",
      users: [
        { name: "1d6", admin: true },
        { name: "Jean", admin: false },
        { name: "Valjean", admin: false }
      ],
      items: ["un bras", "une jambe"],
      id: 2
    });
  }
};
</script>

<style scoped>
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

.item-list {
  max-height: 400px;
  overflow: auto;
}
</style>
