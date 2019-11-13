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

<style>
html {
  background-color: #eee;
}
</style>

<style scoped>
main {
  width: 80%;
  margin: 0 auto;
  margin-top: 20px;
  padding: 20px;
  border-radius: 1px;
  height: 100%;
  background-color: white;
}
</style>
