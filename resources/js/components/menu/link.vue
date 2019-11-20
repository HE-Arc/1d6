<template>
  <router-link
    :to="link"
    class="navbar-item"
  >
    <slot />
  </router-link>
</template>

<script>
export default {
  props: {
    'link': {type: String, required: true}
  }
};
</script>