<template>
  <nav
    class="navbar"
    role="navigation"
    aria-label="main navigation"
  >
    <div class="navbar-brand">
      <a
        class="navbar-item"
        href=""
      >
        <img
          src="https://cdn.discordapp.com/icons/628956181922185246/5c74d1ba261f479dfa5ec5a357107ebd.webp?size=128"
        > 
        <menu-link>Indécis</menu-link>
      </a>

      <a
        role="button"
        class="navbar-burger burger"
        aria-label="menu"
        aria-expanded="false"
        data-target="navbarBasicExample"
      >
        <span aria-hidden="true" />
        <span aria-hidden="true" />
        <span aria-hidden="true" />
      </a>
    </div>

    <div
      id="navbarBasicExample"
      class="navbar-menu"
    >
      <div class="navbar-end">
        <menu-link
          link="vote"
        >
          Create a poll
        </menu-link>
          
        <menu-link
          link="groups"
        >
          Groups
        </menu-link>

        <div class="navbar-item">
          <div class="buttons">
            <a
              class="button is-primary"
              href="register"
            >
              <strong>Sign up</strong>
            </a>
            <a
              class="button is-light"
              href="login"
            >
              Log in
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import menuLink from '~/components/menu/link';

export default {
  components: {
    menuLink
  }
};
</script>