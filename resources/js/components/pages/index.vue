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
        />
      </span>
      </div>
      <div class="column container-border container-active poll-card is-one-quarter">
        <span class="header">Film de lel</span>
        <b>2 / 12</b> users voted<br>
        <a href="#">Take part to the poll</a>
      </div>
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
        />
      </span>
      </div>
      <div class="column container-border poll-card is-one-quarter">
        <span class="header">Mangeur de lel</span>
        Poll ended on 10.12.2019<br>
      </div>
      <div class="column container-border poll-card is-one-quarter">
        <span class="header">Mangeur de lel</span>
        Poll ended on 10.12.2019<br>
      </div>
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
