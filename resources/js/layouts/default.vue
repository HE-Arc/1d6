<template>
  <div>
    <nav-menu />
    <main>
      <slot />
    </main>
  </div>
</template>

<script>
import navMenu from "../components/menu/nav-menu";

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

@media only screen and (max-width: 1024px) {
  main {
    width: 90%;
  }
}

@media only screen and (max-width: 500px) {
  main {
    width: 98%;
    margin-left: 1%;
    margin-right: 1%;
  }
}
</style>
