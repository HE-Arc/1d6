<template>
  <div class="column container-border poll-card is-one-quarter">
    <span class="header">{{group.name}}</span>
    <b>{{group.userCount}}</b> members
    <br />
    <span v-if="group.isAdmin" class="poll-card-action">
      <a href="#" v-on:click="editFunction(group.id)">
        <i class="fa fa-edit"></i> Edit
      </a>
    </span>
    <span v-if="group.isAdmin" class="poll-card-action">
      <a href="#" v-on:click="deleteFunction(group.id)">
        <i class="fa fa-trash"></i> Delete
      </a>
    </span>
    <span class="poll-card-action">
      <a href="#" v-on:click="editRatingsFunction(group.id)">
        <i class="fa fa-star"></i> Stars
      </a>
    </span>
  </div>
</template>

<script>
export default {
  props: ["group", "editFunction", "deleteFunction", "editRatingsFunction"]
};
</script>