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

<style scoped>
main {
  width: 30%;
  margin: 0 auto;
  margin-top: 5%;
  padding: 20px;
  border-radius: 1px;
  height: 100%;
  background-color: white;
}

@media only screen and (max-width: 1024px) {
  main {
    width: 40%;
  }
}

@media only screen and (max-width: 600px) {
  main {
    width: 98%;
    margin-left: 1%;
    margin-right: 1%;
  }
}
</style>
