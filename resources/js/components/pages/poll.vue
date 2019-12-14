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

let pollPollingInterval;

export default {
  data() {
    return {
      items: [
        { name: "Loading...", weight: 1 },
        { name: "Loading...", weight: 1 },
        { name: "Loading...", weight: 1 },
        { name: "Loading...", weight: 1 }
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
        this.axios
          .get("/polls/" + parseInt(this.$route.params.id) + "/lite")
          .then(response => {
            const poll = response.data ? response.data.data : {};

            this.userCount = poll.user_count;

            // Update weights
            for (let i = 0; i < poll.items.length; i++) {
              for (let j = 0; j < this.items.length; j++) {
                if (poll.items[i].id === this.items[j].id) {
                  this.items[j].weight = poll.items[i].weight;
                }
              }
            }

            // Find voted item
            let votedItem = "";
            if (poll.chosen_item_id !== -1) {
              for (let i = 0; i < this.items.length; i++) {
                if (this.items[i].id === poll.chosen_item_id) {
                  votedItem = this.items[i].name;
                  break;
                }
              }
            }

            if (votedItem !== "") {
              this.isSpinning = true;
              this.isFinished = true;

              for (let i = 0; i < this.items.length; i++) {
                if (votedItem.includes("Mario Kart")) {
                  // This will probably not work if the user has insuficient trust level in most cases anyway
                  const audio = new Audio(
                    "https://orikaru.net/dl/1d6-unknown-music.mp3"
                  );
                  audio.play();
                  break;
                }
              }

              wheel.methods.spin(votedItem);
            }
          })
          .catch(error => {
            // TODO: Better error handling
            console.log(error);
          });
      }
    }
  },
  mounted() {
    this.axios
      .get("/polls/" + parseInt(this.$route.params.id))
      .then(response => {
        const poll = response.data ? response.data.data : {};

        this.isAdmin = poll.is_admin;
        // TODO: Make the wheel spin instant here
        this.isFinished = poll.chosen_item_id !== -1;
        this.canRate = !poll.has_voted;
        this.userCount = poll.user_count;
        this.totalUserCount = poll.total_user_count;

        // Note: this may not be the correct "vue" way of doing things? but that's how the ratingsList item component works
        this.$refs.ratingsList.items = [];
        this.items = [];

        for (let i = 0; i < poll.items.length; i++) {
          this.$refs.ratingsList.items.push({
            name: poll.items[i].name,
            rating: poll.items[i].weight || 1
          });

          this.items.push({
            name: poll.items[i].name,
            weight: poll.items[i].weight || 1
          });
        }
      })
      .catch(error => {
        // TODO: Better error handling
        alert("Could not load this poll, please try again in a moment.");
        console.log(error);
        this.$router.replace("/");
      });

    this.pollServer();

    pollPollingInterval = setInterval(() => {
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
