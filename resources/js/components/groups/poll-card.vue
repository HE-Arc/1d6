<template>
  <div class="column container-border container-active poll-card is-one-quarter">
    <span class="header">{{name}}</span>
    <b>{{readyUserCount}} / {{totalUserCount}}</b> users voted
    <br />
    <a href="#">
      <span v-show="!isClosed">Take part to the poll</span>
      <span v-show="isClosed">View results</span>
    </a>
  </div>
</template>

<script>
export default {
  props: ["name", "id", "totalUserCount", "readyUserCount", "isClosed"]
};
</script>