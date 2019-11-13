<template>
  <div>
    <nav-menu />
    <main>
      <nuxt />
    </main>
  </div>
</template>

<script>
import navMenu from '~/components/menu/nav-menu';

export default {
  components: {
    navMenu
  }
};
</script>

<style scoped>
main {
  width: 20%;
  margin: 0 auto;
  margin-top: 5%;
  padding: 20px;
  border-radius: 1px;
  height: 100%;
  background-color: white;
}
</style>
