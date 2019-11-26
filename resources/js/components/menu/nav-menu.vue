<template>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href>
        <img
          src="https://cdn.discordapp.com/icons/628956181922185246/5c74d1ba261f479dfa5ec5a357107ebd.webp?size=128"
        />
        <menu-link link="/">Indécis</menu-link>
      </a>

      <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false">
        <!-- TODO: Handle nav burger -->

        <span aria-hidden="true" />
        <span aria-hidden="true" />
        <span aria-hidden="true" />
      </a>
    </div>

    <div class="navbar-menu">
      <div class="navbar-end">
        <menu-link link="poll">Create a poll</menu-link>

        <menu-link link="groups">Groups</menu-link>

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
      this.$router.replace('/login');
    }
  }
};
</script>