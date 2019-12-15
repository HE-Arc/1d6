<template>
  <modal
    title="Create a new group"
    save-text="Create"
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
          :add-function="addUser"
          :remove-function="removeUser"
          ref="userList"
        >Members</select-list>
      </div>
      <div class="column is-half">
        <select-list
          icon="fa-plus"
          placeholder="Item name"
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
      group: placeholderGroup
    };
  },
  methods: {
    open: function() {
      this.group = placeholderGroup;

      // Set the user as unremovable entry in list
      this.$refs.userList.unremovableItems.push({
        id: localStorage.getItem("id"),
        name: localStorage.getItem("username")
      });
      this.$refs.modal.active = true;
    },
    save: function() {
      // Add admin parameter
      let usersData = this.groups.users.map(user => {
        return {
          id: user.id,
          admin: false
        };
      });
      // Add self to the group
      usersData.push({
        id: localStorage.getItem("id"),
        admin: true
      });

      // Send to the API
      this.axios
        .post("/groups", {
          name: this.group.name,
          users: usersData,
          items: this.group.items
        })
        .then(response => {
          this.$parent.groups.push(this.group);
        })
        .catch(error => {
          alert("ERROR: Could not save group");
        });
    },
    close: function() {},
    addUser: function(email) {
      this.axios
        .get("/users/by-mail/" + email)
        .then(response => {
          // TODO: check the conditions for an empty answer
          if (response.data && response.data.data) {
            let newUser = response.data.data;
            if (
              this.group.users.filter(user => user.id === newUser.id).length ===
              0
            ) {
              this.group.users.push(newUser);
              ++this.group.userCount;
            }
          }
        })
        .catch(error => {
          alert("ERROR: Could not get user");
        });
    },
    removeUser: function(userToRemove) {
      this.group.users.splice(
        this.group.users.findIndex(user => user.id === userToRemove.id),
        1
      );
      --this.group.userCount;
    },
    addItem: function(itemName) {
      this.group.items.push({
        name: itemName,
        description: "",
        url: "",
        image_url: ""
      });
      this.group.userCount;
    },
    removeItem: function(itemToRemove) {
      this.group.items.splice(
        this.group.items.findIndex(item => item.name === itemToRemove.name),
        1
      );
    }
  }
};

let placeholderGroup = {
  name: "Loading ...",
  users: [],
  items: [],
  userCount: 0
};
</script>

<style scoped>
.input-group-name {
  margin-bottom: 20px;
  width: auto;
}
</style>