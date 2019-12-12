<template>
  <default-layout>
    <div class="columns">
      <div class="column is-one-third">
        <h1>Your votes</h1>
        <div class="field">
          <select-ratings :read-only="!canRate || isFinished" ref="ratingsList">Ratings</select-ratings>
        </div>
        <div class="buttons is-right">
          <p v-show="isFinished">This poll is closed</p>
        </div>
      </div>
      <div class="column is-two-third has-border">
        <h1>Poll</h1>
        <div class="canvas-container">
          <wheel :items="items"></wheel>
          <div class="vote-status">
            <b>{{userCount}} / {{totalUserCount}}</b>
            <i class="fa fa-users"></i>
          </div>
          <div class="buttons has-addons is-centered">
            <p v-show="isSpinning">Spinning the wheel!</p>
            <p v-show="isFinished && !isSpinning">This poll is closed</p>
          </div>
        </div>
      </div>
    </div>
  </default-layout>
</template>
<script>
import selectRatings from "../items/select-ratings";
import wheel from "../wheel";

// TODO In a very very far furture, use websockets
const POLLING_INTERVAL = 1000;

export default {
  data() {
    return {
      items: [
      isFinished: false, // Will automatically be changed in pollServer
      isSpinning: false, // Will automatically be changed in pollServer
      userCount: 0, // Will automatically be changed in pollServer
      totalUserCount: 0 // Will automatically be changed in pollServer
    };
  },
  methods: {
    spinWheel(votedItem) {
      this.isSpinning = true;
      // Wheel will automatically be spinned when the server answers it in the polling
      // TODO: Send data to the server
    },
    pollServer() {
      if (!this.isFinished) {
        // TODO: Query API and fill result
        const result = {
          totalUserCount: 5,
          userCount: 2,
        };

        this.totalUserCount = result.totalUserCount;
        this.userCount = result.userCount;
        if (result.votedItem !== "") {
          this.isFinished = true;
        }
    }
  },
    this.pollServer();
    setInterval(() => {
      this.pollServer();
    }, POLLING_INTERVAL);
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