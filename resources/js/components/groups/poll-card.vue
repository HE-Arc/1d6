<template>
  <div
    :class="{'container-active': !isClosed}"
    class="column container-border poll-card is-one-quarter"
  >
    <span class="header">{{name}}</span>
    <b>{{readyUserCount}} / {{totalUserCount}}</b> users voted
    <br />
    <router-link :to="{name: 'poll', params: {id: id}}">
      <span v-show="!isClosed">Take part to the poll</span>
      <span v-show="isClosed">View results</span>
    </router-link>
  </div>
</template>

<script>
export default {
  props: ["name", "id", "totalUserCount", "readyUserCount", "isClosed"]
};
</script>