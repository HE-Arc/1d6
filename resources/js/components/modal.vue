<template>
  <div class="modal" v-bind:class="{'is-active' : active}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">{{title}}</p>
        <button class="delete" aria-label="close" v-on:click="close"></button>
      </header>
      <section class="modal-card-body">
        <slot></slot>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-success" v-on:click="save">{{saveText}}</button>
        <button class="button" v-on:click="close">Cancel</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  props: ["title", "save-text", "save-function", "close-function"],
  data() {
    return {
      active: false,
    };
  },
  methods: {
    close: function() {
      this.active = false;
      this.closeFunction();
    },
    save: function() {
      this.saveFunction();
      this.close();
    }
  }
};
</script>