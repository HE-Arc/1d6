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
      polls: [
        {
          id: -1,
          name: "Loading polls...",
          readyUserCount: 0,
          totalUserCount: "?"
        }
      ],
      closedPolls: [
        {
          id: -1,
          name: "Loading past polls...",
          readyUserCount: 0,
          totalUserCount: "?"
        }
      ]
    };
  }
};
</script>

<style>
</style>
