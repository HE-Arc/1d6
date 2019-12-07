<template>
  <div class="column container-border poll-card is-one-quarter">
    <span class="header">{{group.name}}</span>
    <b>{{group.users.length}}</b> members
    <br />
    <span class="poll-card-action">
      <a href="#">
        <i class="fa fa-edit"></i> Edit
      </a>
    </span>
    <span class="poll-card-action">
      <a href="#">
        <i class="fa fa-trash"></i> Delete
      </a>
    </span>
    <span class="poll-card-action">
      <a href="#">
        <i class="fa fa-star"></i> Stars
      </a>
    </span>
  </div>
</template>

<script>
export default {
  props: [
      "group",
  ],
};
</script>