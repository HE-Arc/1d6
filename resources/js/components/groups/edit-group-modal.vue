<template>
  <modal
    title="Edit existing group"
    save-text="Save"
    :save-function="save"
    :close-function="close"
    ref="modal"
  >
    <label class="label">Group name</label>
    <input
      type="text"
      placeholder="Where are we gonna eat ?"
      class="input input-group-name"
      v-model="group.name"
    />
    <div class="columns">
      <div class="column is-half">
        <select-list
          icon="fa-user-plus"
          placeholder="Member email"
          :items="displayedUsers"
          :add-function="addUser"
          :remove-function="removeUser"
          ref="userList"
        >Members</select-list>
      </div>
      <div class="column is-half">
        <select-list
          icon="fa-plus"
          placeholder="Item name"
          :items="displayedItems"
          :add-function="addItem"
          :remove-function="removeItem"
        >Default items</select-list>
      </div>
    </div>
  </modal>
</template>

<script>
import modal from "../modal";
import selectList from "../groups/select-list";

export default {
  components: {
    modal,
    selectList
  },
  data() {
    return {
      group: {},
      usersToAdd: [],
      usersToRemove: [],
      itemsToAdd: [],
      itemsToRemove: [],
      displayedUsers: [],
      displayedItems: []
    };
  },
  methods: {
    open: function(id) {
      this.usersToAdd = [];
      this.usersToRemove = [];
      this.itemsToAdd = [];
      this.itemsToRemove = [];
      
      this.axios
        .get("/groups/" + id)
        .then(response => {
          this.group = response.data.data;

          let ownId = parseInt(localStorage.getItem("id"));
          this.displayedUsers = this.group.users.filter(
            user => user.id !== ownId
          );
          this.displayedItems = this.group.items;

          this.$refs.userList.unremovableItems = this.group.users.filter(
            user => user.id === ownId
          );
          this.$refs.userList.unremovableItems[0].name += " (You)";
          this.$refs.modal.active = true;
        })
        .catch(error => {
          alert("ERROR: Could not load group");
        });
    },
    save: function() {
      this.axios
        .patch("/groups/" + this.group.id, {
          name: this.group.name,
          users_to_add: this.usersToAdd.map(user => {
            return { id: user.id, admin: false };
          }),
          users_to_remove: this.usersToRemove.map(user => {
            return { id: user.id };
          }),
          items_to_add: this.itemsToAdd,
          items_to_remove: this.itemsToRemove.map(item => {
            return { id: item.id };
          })
        })
        .then(response => {
          let parentsGroup = this.$parent.$parent.groups.find(
            group => group.id === this.group.id
          );
          // This will change the page below.
          parentsGroup.name = this.group.name;
          parentsGroup.userCount =
            this.group.users.length +
            this.usersToAdd.length -
            this.usersToRemove.length;
        })
        .catch(error => {
          alert("ERROR: Could not save group");
        });
    },
    close: function() {
      // TODO: prevent the group being renamed on the groups page
    },
    addItem: function(itemName) {
      if (
        this.group.items.filter(item => item.name === itemName).length === 0 &&
        this.itemsToAdd.filter(item => item.name === itemName).length === 0
      ) {
        // Remove from the "toRemove list" just in case
        let index = this.itemsToRemove.findIndex(
          item => item.name === itemName
        );
        if (index > -1) {
          this.itemsToRemove.splice(index, 1);
        }

        let newItem = {
          name: itemName,
          description: "",
          url: "",
          image_url: ""
        };
        this.itemsToAdd.push(newItem);
        this.displayedItems.push(newItem);
      }
    },
    removeItem: function(itemToRemove) {
      this.displayedItems.splice(
        this.displayedItems.findIndex(item => item.name === itemToRemove.name),
        1
      );
      // Remove it from its current list
      let index = this.itemsToAdd.findIndex(
        item => item.name === itemToRemove.name
      );
      if (index > -1) {
        // This was a new addition, so we just have to remove it from itemsToAdd
        this.itemsToAdd.splice(index, 1);
      } else {
        // It was in the group's items already => add to itemsToRemove
        this.itemsToRemove.push(itemToRemove);
      }
    },
    addUser: function(email) {
      this.axios
        .get("/users/by-mail/" + encodeURIComponent(email))
        .then(response => {
          // TODO: check the conditions for an empty answer
          if (response.data && response.data.data) {
            let newUser = response.data.data;
            if (
              this.group.users.filter(user => user.id === newUser.id).length ===
              0
            ) {
              this.usersToAdd.push(newUser);
              this.displayedUsers.push(newUser);
            }
          }
        })
        .catch(error => {
          alert("ERROR: Could not get user");
        });
    },
    removeUser: function(userToRemove) {
      this.displayedUsers.splice(
        this.displayedUsers.findIndex(user => user.name === userToRemove.name),
        1
      );
      // Remove it from its current list
      let index = this.usersToAdd.findIndex(
        user => user.name === userToRemove.name
      );
      if (index > -1) {
        // This was a new addition, so we just have to remove it from usersToAdd
        this.usersToAdd.splice(index, 1);
      } else {
        // It was in the group's users already => add to usersToRemove
        this.usersToRemove.push(userToRemove);
      }
    }
  }
};
</script>

<style scoped>
.input-group-name {
  margin-bottom: 20px;
  width: auto;
}
</style>