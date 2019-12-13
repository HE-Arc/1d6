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
      editedGroupReference: {},
      groups: []
    };
  },
  methods: {
    populateAndDisplayGroupModal: function() {
      this.$refs.groupName = this.currentGroup.name;
      this.$refs.groupUsers.unremovableItems = [
        localStorage.getItem("username") + " (you)"
      ];
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
      this.currentGroup = this.groups.find(group => group.id === id);
      let currentObj = this;
      this.axios
        .get("/groups/" + id)
        .then(function(response) {
          currentObj.currentGroup = response.data.data;
          console.log(currentObj.currentGroup);
          currentObj.editedGroupReference = JSON.parse(
            JSON.stringify(currentObj.currentGroup)
          );

          // remove self from the list so that it doesn't appear twice
          currentObj.currentGroup.users.splice(
            currentObj.currentGroup.users.findIndex(
              user => user.id == localStorage.getItem("id")
            ),
            1
          );

          currentObj.$refs.groupModal.title = "Edit group";
          currentObj.$refs.groupModal.saveText = "Save";
          currentObj.$refs.groupModal.saveFunction = currentObj.saveGroup;

          currentObj.populateAndDisplayGroupModal();
        })
        .catch(function(error) {
          // TODO: better error handling
          alert("ERROR: Could not load group");
          console.log(error);
        });
    },
    editRatings: function(id) {
      // TODO: get default ratings from user for this group's items from API using id
      let defaultRatings = this.groups.find(group => group.id === id).items;

      this.$refs.ratingsList.items = defaultRatings;
      this.$refs.ratingsModal.title = "Edit your default ratings";
      this.$refs.ratingsModal.saveText = "Save";

      this.$refs.ratingsModal.closeFunction = () => {
        this.$refs.ratingsList.items = [];
      };
      this.$refs.ratingsModal.saveFunction = (rating, item) => {
        // TODO: actually modify the DB using the API
        this.currentGroup.items = defaultRatings;
      };

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
      let currentObj = this;
      this.axios.post("/groups").then;
      this.groups.push(this.currentGroup);
    },
    saveGroup: function() {
      let request = {};
      request.id = this.editedGroupReference.id;
      request.name = this.currentGroup.name;
      request.usersToAdd = [];
      request.usersToRemove = [];
      request.itemsToAdd = [];
      request.itemsToRemove = [];

      let oldUsers = new Set(this.editedGroupReference.users.map(user => user.id));
      let newUsers = new Set(this.currentGroup.users.map(user => user.id));
      let oldItems = new Set(this.editedGroupReference.items.map(item => item.id));
      let newItems = new Set(this.currentGroup.items.map(item => item.id));

      request.usersToAdd = difference(newUsers, oldUsers);
      request.usersToRemove = difference(oldUsers, newUsers);
      request.itemsToAdd = difference(newItems, oldItems);
      request.itemsToRemove = difference(oldItems, newItems);

      console.log("userstoadd")
      console.log(request.usersToAdd)
      console.log("userstoremove")
      console.log(request.usersToRemove)
      
      
      // this.axios
      //   .put("/groups", this.currentGroup)
      //   .then(function(response) {
      //     // nothing ??? should be good already
      //   })
      //   .catch(function(error) {
      //     // TODO: better error handling
      //     alert("ERROR: Could not update group");
      //   });
    },
    deleteGroup: function(id) {
      let currentObj = this;
      this.axios
        .delete("/groups/" + id)
        .then(function(response) {
          currentObj.groups.splice(
            currentObj.groups.findIndex(group => group.id === id),
            1
          );
        })
        .catch(function(error) {
          // TODO: better error handling
          alert("ERROR: Could not delete group");
        });
    }
  },
  mounted: function() {
    this.groups = [];
    let currentObj = this;
    this.axios
      .get("/users/" + localStorage.getItem("id"))
      .then(function(response) {
        currentObj.groups = response.data.data.groups;
        console.log(currentObj.groups);
      })
      .catch(function(error) {
        // TODO: better error handling
        alert("ERROR: Could not load groups");
      });
  }
};

function difference(setA, setB) {
  let _difference = new Set(setA);
  for (let elem of setB) {
    _difference.delete(elem);
  }
  return _difference;
}

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
