<template>
  <default-layout>
    <div class="columns">
      <div class="column is-one-third">
        <h1>Your votes</h1>
        <div class="field">
          <select-ratings />
        </div>
        <div class="buttons is-right">
          <button type="submit" class="button is-primary">Submit ratings</button>
        </div>
      </div>
      <div class="column is-two-third has-border">
        <h1>Poll</h1>
        <div class="canvas-container">
          <wheel :items="items"></wheel>
          <div class="vote-status">
            <b>3 / 4</b>
            <i class="fa fa-users"></i>
          </div>
          <div class="buttons has-addons is-centered">
            <button type="submit" v-on:click="spinWheel" class="button is-info">Spin the wheel</button>
            <!--
            <button type="submit" class="button is-light">Waiting for owner to spin the wheel</button>
            -->
          </div>
        </div>
      </div>
    </div>
  </default-layout>
</template>
<script>
import selectRatings from "../items/select-ratings";
import wheel from "../wheel";

export default {
  data() {
    return {
      items: [
        { name: "King Food", weight: 0.2 },
        { name: "Coop", weight: 0.2 },
        { name: "Vegan", weight: 0.6 }
      ]
    };
  },
  methods: {
    spinWheel() {
      // TODO: Only send data to server, use a timeout to retrieve eventual score / items

      //this.items[2].weight = 0.4;
      wheel.methods.spin("Vegan");
    }
  },
  components: {
    selectRatings,
    wheel
  },
  middleware: "auth"
};

</script>

<style scoped>
.vote-status {
  margin: 20px;
}

.canvas-container {
  text-align: center;
  margin: 0 auto;
  width: 100%;
}

@media only screen and (min-width: 769px) {
  .has-border {
    border-left: 1px solid #eee;
  }
}

@media only screen and (max-width: 768px) {
  .has-border {
    border-top: 1px solid #eee;
  }
}
</style>