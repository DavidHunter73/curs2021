<template>
  <div>
    <p>Soy el libro con el isbn {{ isbn }}, que chulo</p>
    <star-rating
      v-model="rating"
      v-bind:rating="rating"
      v-bind:show-rating="false"
    ></star-rating>
  </div>
</template>

<script>
import StarRating from "vue-star-rating";

export default {
  data() {
    return {
      isbn: "???",
      rating: 0,
    };
  },
};
</script>

<style>
</style>