<template>
  <header class="container">
    <h2>HEADER</h2>

    <router-link
      to="/dhernandez/ProyectoFinal/Liber/public/example/"
      class="nav-link"
    >
      Example de Vue
    </router-link>

    <br />

    <router-link to="/dhernandez/ProyectoFinal/Liber/public/" class="nav-link">
      Home
    </router-link>

    <br />

    <router-link
      to="/dhernandez/ProyectoFinal/Liber/public/genre"
      class="nav-link"
    >
      Genero
    </router-link>
  </header>
</template>

<script>
export default {
  data() {
    return {};
  },
  mounted() {},
};
</script>

<style>
header {
  background-color: #741341;
  color: white;
  margin: 0;
  padding: 0;
}
</style>