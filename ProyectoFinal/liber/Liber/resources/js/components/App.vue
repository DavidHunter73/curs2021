<template>
  <div class="container">
    <Header />
    <router-view></router-view>
  </div>
</template>

<script>
import Header from "./Header.vue";

export default {
  components: {
    Header,
  },
};
</script>

<style>
body {
  padding: 0;
  margin: 0;
}
</style>