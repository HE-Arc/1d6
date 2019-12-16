<template>
  <default-layout>
    <add-group-modal ref="addGroupModal" />
    <edit-group-modal ref="editGroupModal" />
    <edit-default-ratings-modal ref="editDefaultRatingsModal" />

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
import addGroupModal from "../groups/add-group-modal";
import editGroupModal from "../groups/edit-group-modal";
import editDefaultRatingsModal from "../items/edit-default-ratings-modal";
import groupCard from "../groups/group-card";

export default {
  components: {
    addGroupModal,
    editGroupModal,
    editDefaultRatingsModal,
    groupCard
  },
  data() {
    return {
      groups: []
    };
  },
  methods: {
    createGroup: function() {
      this.$refs.addGroupModal.open();
    },
    editGroup: function(id) {
      this.$refs.editGroupModal.open(id);
    },
    editRatings: function(id) {
      this.$refs.editDefaultRatingsModal.open(id);
    },
    deleteGroup: function(id) {
      this.axios
        .delete("/groups/" + id)
        .then(response => {
          this.groups.splice(
            this.groups.findIndex(group => group.id === id),
            1
          );
        })
        .catch(error => {
          // TODO: better error handling
          alert("ERROR: Could not delete group");
        });
    }
  },
  mounted: function() {
    this.groups = [];
    this.axios
      .get("/groups/")
      .then(response => {
        response.data.data.forEach(group => {
          this.groups.push({
            id: group.id,
            name: group.name,
            userCount: group.user_count,
            isAdmin: group.is_admin
          });
        })
      })
      .catch(error => {
        // TODO: better error handling
        alert("ERROR: Could not load groups");
      });
  }
};
</script>
