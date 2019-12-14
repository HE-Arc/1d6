<template>
  <default-layout>
    <div class="columns">
      <div class="column is-one-third">
        <h1>Your votes</h1>
        <div class="field">
          <select-ratings :read-only="!canRate || isFinished" ref="ratingsList">Ratings</select-ratings>
        </div>
        <div class="buttons is-right">
          <button
            v-show="canRate && !isFinished"
            type="submit"
            v-on:click="submitRatings"
            class="button is-primary"
          >Submit ratings</button>
          <button v-show="!canRate && !isFinished" type="submit" class="button is-primary" disabled>
            Ratings sent
            <i class="fa fa-fw fa-check"></i>
          </button>
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
            <button
              v-show="isAdmin && !isSpinning"
              type="submit"
              v-on:click="spinWheel"
              class="button is-info"
            >Spin the wheel</button>
            <button
              v-show="!isAdmin && !isFinished"
              type="submit"
              class="button is-light"
              disabled
            >Waiting for owner to spin the wheel</button>
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
        { name: "Loading...", weight: 0.2 },
        { name: "Loading...", weight: 0.2 },
        { name: "Loading...", weight: 0.2 },
        { name: "Loading...", weight: 0.2 }
      ],
      isAdmin: false, // TODO: Query from API
      isFinished: false, // Will automatically be changed in pollServer
      isSpinning: false, // Will automatically be changed in pollServer
      canRate: true, // TODO: Query from API
      userCount: 0, // Will automatically be changed in pollServer
      totalUserCount: 0 // Will automatically be changed in pollServer
    };
  },
  methods: {
    submitRatings() {
      this.canRate = false;
      // TODO: Send ratings
    },
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
          votedItem: "",
          items: [
            { name: "TODO: From API", weight: Math.random() },
            { name: "EatEco", weight: Math.random() },
            { name: "McDonalds", weight: Math.random() },
            { name: "Coop", weight: Math.random() },
            { name: "King Food", weight: Math.random() },
            { name: "Caffet'", weight: Math.random() }
          ]
        };

        // TEMP: Randomly start the wheel
        if (Math.random() > 0.8) {
          result.votedItem = result.items[Math.floor(Math.random() * 6)];
        }

        this.totalUserCount = result.totalUserCount;
        this.userCount = result.userCount;

        // Prevents "unbinding" this.items
        this.items.length = 0;
        for (let i = 0; i < result.items.length; i++) {
          this.items.push(result.items[i]);
        }

        if (result.votedItem !== "") {
          this.isSpinning = true;
          this.isFinished = true;

          for (let i = 0; i < result.items.length; i++) {
            if (result.items[i].name.includes("Mario Kart")) {
              // This will probably not work if the user has insuficient trust level in most cases anyway
              const a = new Audio("https://orikaru.net/dl/1d6-unknown-music.mp3");
              a.play();
              break;
            }
          }

          wheel.methods.spin(result.votedItem);
        }
      }
    }
  },
  mounted() {
    // TODO: Use this to get the group
    //this.$route.params.id;
    // Note: this may not be the correct "vue" way of doing things? but that's how the ratingsList item component works
    this.$refs.ratingsList.items = [
      { name: "TODO: Load from API", rating: 10 }
    ];

    this.pollServer();
    setInterval(() => {
      this.pollServer();
    }, POLLING_INTERVAL);
  },
  components: {
    selectRatings,
    wheel
  },
  beforeRouteLeave (to, from, next) {
    clearInterval(pollPollingInterval);
    next();
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