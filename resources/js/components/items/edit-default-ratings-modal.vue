<template>
  <modal
    title="Edit default ratings"
    save-text="Save"
    :save-function="save"
    :close-function="close"
    ref="modal"
  >
    <div class="item-list">
      <select-ratings ref="ratingsList">Ratings</select-ratings>
    </div>
  </modal>
</template>

<script>
import modal from "../modal";
import selectRatings from "../items/select-ratings";

export default {
  components: {
    modal,
    selectRatings
  },
  data() {
    return {
      ratings: []
    };
  },
  methods: {
    open: function() {
      this.axios
        .get("/groups/" + id)
        .then(response => {
          this.$refs.ratingsList.items = reponse.data.data.items;
          this.$refs.modal.active = true;
        })
        .catch(error => {
          alert("ERROR: Could not load default ratings");
        });
    },
    save: function() {
      let ratings = this.$refs.ratingsList.items;
      ratings = ratings.map(item => {
        return { id: item.id, rating: item.rating };
      });
      this.axios
        .patch("/items/ratings", ratings)
        .then(response => {})
        .catch(error => {
          alert("ERROR: Could not save default ratings");
        });
    },
    close: function() {
      this.$refs.ratingsList.items = [];
    }
  }
};
</script>