<template>
  <default-layout>
    <h1>Active polls</h1>
    <div
      class="columns is-multiline is-1-mobile is-0-tablet is-3-desktop is-8-widescreen container-container"
    >
      <span v-for="poll in polls" v-bind:key="poll.id">
        <poll-card
          :id="poll.id"
          :name="poll.name"
          :ready-user-count="poll.readyUserCount"
          :total-user-count="poll.totalUserCount"
          :is-closed="0"
        />
      </span>
      <span v-show="polls.length === 0">No active polls</span>
    </div>
    <h1>Past polls</h1>
    <div
      class="columns is-multiline is-1-mobile is-0-tablet is-3-desktop is-8-widescreen container-container"
    >
      <span v-for="poll in closedPolls" v-bind:key="poll.id">
        <poll-card
          :id="poll.id"
          :name="poll.name"
          :ready-user-count="poll.readyUserCount"
          :total-user-count="poll.totalUserCount"
          :is-closed="1"
        />
      </span>
      <span class="no-past-polls" v-show="closedPolls.length === 0">No past polls</span>
    </div>
  </default-layout>
</template>

<script>
import pollCard from "../groups/poll-card";

export default {
  components: {
    pollCard
  },
  data() {
    return {
      polls: [],
      closedPolls: []
    };
  },
  mounted() {
    this.axios
      .get("/polls")
      .then(response => {
        const polls = response.data ? response.data.data : [];

        this.polls = [];
        this.closedPolls = [];

        for (let i = 0; i < polls.length; i++) {
          const poll = polls[i];
          const pollData = {
            id: poll.id,
            name: poll.name,
            readyUserCount: poll.user_count,
            totalUserCount: poll.total_user_count
          };
          if (poll.id === -1) {
            // Poll is open
            this.polls.push(pollData);
          } else {
            // Poll is closed
            this.closedPolls.push(pollData);
          }
        }
      })
      .catch(error => {
        // TODO: Better error handling
        alert("Could not load polls, please try again in a moment.");
        console.log(error);
        this.polls = [];
        this.closedPolls = [];
      });
  }
};
</script>

<style scoped>
.no-past-polls {
  margin-bottom: 20px;
}
</style>
