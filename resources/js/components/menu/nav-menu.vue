<template>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <router-link class="navbar-item" to="/">
        <img src="/images/logo.png" />
        <menu-link link="/">Indécis</menu-link>
      </router-link>

      <a
        role="button"
        class="navbar-burger burger"
        data-target="navMenu"
        aria-label="menu"
        aria-expanded="false"
      >
        <span aria-hidden="true" />
        <span aria-hidden="true" />
        <span aria-hidden="true" />
      </a>
    </div>

    <div class="navbar-menu" id="navMenu">
      <div class="navbar-end">
        <menu-link v-show="connected" link="create-poll">Create a poll</menu-link>

        <menu-link v-show="connected" link="groups">Groups</menu-link>

        <div class="navbar-item">
          <div class="buttons">
            <router-link v-show="!connected" class="button is-primary" to="register">
              <strong>Sign up</strong>
            </router-link>
            <router-link v-show="!connected" class="button is-light" to="login">Log in</router-link>
            <button
              v-on:click="logout"
              v-show="connected"
              class="button is-light"
              to="login"
            >Log out</button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import menuLink from "./link";

export default {
  components: {
    menuLink
  },
  data() {
    return {
      connected: localStorage.getItem("apiToken") !== null
    };
  },
  methods: {
    logout() {
      localStorage.clear();
      this.$router.replace("/login");
    }
  },
  mounted() {
    // Source: https://bulma.io/documentation/components/navbar/
    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(
      document.querySelectorAll(".navbar-burger"),
      0
    );

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {
      // Add a click event on each of them
      $navbarBurgers.forEach(el => {
        el.addEventListener("click", () => {
          // Get the target from the "data-target" attribute
          const target = el.dataset.target;
          const $target = document.getElementById(target);

          // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
          el.classList.toggle("is-active");
          $target.classList.toggle("is-active");
        });
      });
    }
  }
};
</script>