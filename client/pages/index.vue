<template>
  <div>
    <div class="container">
      <span class="header">Active polls</span>
      No active polls
    </div>


    <div class="container">
      <span class="header">Past polls</span>
      No past polls
    </div>
  </div>
</template>

<script>
// import Logo from '~/components/Logo.vue';

export default {
  components: {
    
  }
};
</script>

<style>
  .container {
    border-left: 4px solid #ccc;
    padding-left: 20px;
    margin-bottom: 20px;
    margin-top: 20px;
  }

  .header {
    display: block;
    font-size: 1.3em;
  }
</style>
