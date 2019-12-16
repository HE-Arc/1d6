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
      v-model="name"
    />
    <div class="columns">
      <div class="column is-half">
        <select-list
          :items="users"
          icon="fa-user-plus"
          placeholder="Member email"
          :add-function="addUser"
          :remove-function="removeUser"
          ref="userList"
        >Members</select-list>
      </div>
      <div class="column is-half">
        <select-list
          :items="items"
          icon="fa-plus"
          placeholder="Item name"
          :add-function="addItem"
          :remove-function="removeItem"
          ref="itemList"
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
      name: "",
      users: [],
      items: []
    };
  },
  methods: {
    open: function() {
      // Reset group
      this.name = "";
      this.users = [];
      this.items = [];
      this.userCount = 1;

      // Set the user as unremovable entry in list
      this.$refs.userList.unremovableItems = [
        {
          id: parseInt(localStorage.getItem("id")),
          name: localStorage.getItem("username") + " (You)"
        }
      ];

      // Connect to
      // this.$refs.userList.items = this.users;
      // this.$refs.itemList.items = this.items;
      this.$refs.modal.active = true;
    },
    save: function() {
      // Add admin parameter
      let usersData = this.users.map(user => {
        return {
          id: user.id,
          admin: false
        };
      });
      // Add self to the group
      usersData.push({
        id: parseInt(localStorage.getItem("id")),
        admin: true
      });
      this.users.push({
        id: parseInt(localStorage.getItem("id")),
        admin: true
      });

      let itemsData = this.items.map(item => {
        return {
          name: item.name,
          description: "",
          url: "",
          image_url: ""
        };
      });

      this.axios
        .post("/groups", {
          name: this.name,
          users: usersData,
          items: itemsData
        })
        .then(response => {
          this.$parent.$parent.groups.push({
            id: response.data.data.id,
            name: this.name,
            users: this.users,
            userCount: this.userCount,
            isAdmin: true,
            items: []
          });
        })
        .catch(error => {
          alert("ERROR: Could not save group");
        });
    },
    close: function() {},
    addUser: function(email) {
      this.axios
        .get("/users/by-mail/" + encodeURIComponent(email))
        .then(response => {
          if (response.data && response.data.data) {
            let newUser = response.data.data;
            if (
              this.users.filter(user => parseInt(user.id) === newUser.id)
                .length === 0
            ) {
              this.users.push(newUser);
              ++this.userCount;
            }
          }
        })
        .catch(error => {
          alert("ERROR: Could not get user");
        });
    },
    removeUser: function(userToRemove) {
      this.users.splice(
        this.users.findIndex(user => user.id === userToRemove.id),
        1
      );
      --this.userCount;
    },
    addItem: function(itemName) {
      this.items.push({
        name: itemName,
        description: "",
        url: "",
        image_url: ""
      });
      this.userCount;
    },
    removeItem: function(itemToRemove) {
      this.items.splice(
        this.items.findIndex(item => item.name === itemToRemove.name),
        1
      );
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