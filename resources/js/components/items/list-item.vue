<template>
  <span class="list-item">
    <span class="text">
      <slot />
    </span>
    <span class="stars">
      <star-rating
        v-model="rating"
        :increment="0.5"
        :show-rating="false"
        :star-size="20"
        :read-only="readOnly"
        :rounded-corners="true"
        v-on:rating-selected="saveFunction"
      ></star-rating>
    </span>
  </span>
</template>

<script>
import StarRating from "vue-star-rating";

export default {
  components: {
    StarRating
  },
  props: ["initialRating", "saveFunction", "readOnly"],
  data() {
    return {
      rating: this.initialRating
    };
  }
};
</script>

<style scoped>
@media only screen and (min-width: 1600px) {
  .stars {
    float: right;
  }

  .text {
    display: inline-block;
    max-width: calc(100% - 120px);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
}
</style>
