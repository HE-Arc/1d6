<template>
  <nuxt-link
    :to="link"
    class="navbar-item"
  >
    <slot />
  </nuxt-link>
</template>

<script>
export default {
  props: {
    'link': {type: String, required: true}
  }
};
</script>