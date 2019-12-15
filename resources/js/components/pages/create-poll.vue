<template>
  <default-layout>
    <form v-on:submit.prevent="createPoll">
      <h1>Create a new poll</h1>
      <label class="label">Name</label>
      <input type="text" placeholder class="input" v-model="poll.name" />

      <label class="label">Import settings from group</label>
      <div class="field has-addons">
        <div class="control is-expanded">
          <div class="select is-fullwidth">
            <select name="groups" v-model="selectedGroup">
              <option v-for="group in groups" v-bind:key="group" :value="group">{{group.name}}</option>
            </select>
          </div>
        </div>
        <div class="control">
          <button
            type="submit"
            class="button is-primary"
            v-on:click="importGroupSettings"
          >Import settings</button>
        </div>
      </div>
      <hr />

      <div class="columns">
        <div class="column is-half">
          <select-list
            icon="fa-user-plus"
            placeholder="Member name"
            :add-function="addUser"
            :remove-function="removeUser"
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

      <div class="control">
        <button
          type="submit"
          class="button is-primary"
          v-bind:disabled="!isReadyToCreate()"
        >Create poll</button>
      </div>
    </form>
  </default-layout>
</template>
<script>
import selectList from "../groups/select-list";

export default {
  components: {
    selectList
  },
  middleware: "auth",
  data() {
    return {
      groups: [],
      selectedGroup: {},
      poll: {
        name: "",
        users: [{ name: localStorage.getItem("username") + " (You)" }],
        items: []
      }
    };
  },
  methods: {
    isReadyToCreate: function() {
      return this.poll.name !== "" && this.poll.items.length > 0;
    },
    importGroupSettings: function() {
      this.poll.name = selectedGroup.name;

      this.poll.items = [];
      this.selectedGroup.items.forEach(item => {
        this.poll.items.push(item);
      });

      this.poll.users = [this.user];
      this.selectedGroup.users.forEach(user => {
        if (user.id !== localStorage.getItem("id")) {
          this.poll.users.push(user);
        }
      });
    },
    addUser: function(email) {
      this.axios
        .get("/users/by-mail/" + email)
        .then(response => {
          // TODO: check the conditions for an empty answer
          if (response.data && response.data.data) {
            let newUser = response.data.data;
            if (
              this.poll.users.filter(user => user.id === newUser.id).length ===
              0
            ) {
              this.poll.users.push({
                id: newUser.id,
                name: newUser.name,
                admin: false
              });
            }
          }
        })
        .catch(error => {
          alert("ERROR: Could not get user");
        });
    },
    removeUser: function(userToRemove) {
      // Is checking whether the user is in the list necessary ?
      this.poll.users.splice(
        this.poll.users.findIndex(user => user.id === userToRemove.id),
        1
      );
    },
    addItem: function(itemName) {
      // Specialty of this page: the items are created via the api on the spot, not on "create poll"
      this.axios
        .post("/items", {
          name: itemName,
          description: "",
          url: "",
          image_url: ""
        })
        .then(response => {
          this.poll.items.push({
            name: itemName,
            id: response.data.data.id
          });
        })
        .catch(error => {
          alert("ERROR: Could not create item");
        });
    },
    removeItem: function(itemToRemove) {
      // Is checking whether the user is in the list necessary ?
      this.poll.items.splice(
        this.poll.items.findIndex(item => item.id === itemToRemove.id),
        1
      );
    },
    createPoll: function() {
      let data = {
        name: this.poll.name,
        users: this.poll.users.map(user => {
          return { id: user.id, admin: user.admin };
        }),
        items: this.poll.items.map(item => {
          return { id: item.id };
        })
      };
      this.axios
        .post("/polls", data)
        .then(response => {
          router.replace("/poll/" + response.data.data.id);
        })
        .catch(error => {
          alert("ERROR: Could not create poll");
        });
    }
  },
  mounted: function() {
    this.axios
      .get("/users/" + localStorage.getItem("id"))
      .then(response => {
        this.user = {
          id: reponse.data.data.id,
          name: response.data.data.name,
          admin: true
        };
        this.groups = reponse.data.data.groups;
      })
      .catch(error => {
        alert("ERROR: Could not load groups");
      });
  }
};
</script>