<template>
  <a
    :href="link"
    class="navbar-item"
  >
    <slot />
  </a>
</template>

<script>
export default {
  props: {
    'link': {type: String, required: true}
  }
};
</script>