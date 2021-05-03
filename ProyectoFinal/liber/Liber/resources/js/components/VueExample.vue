<template>
  <div class="container">
    <h1>USUARIOS</h1>
    <tr v-for="user in users" :key="user.id">
      <td>{{ user.id }}</td>
      <td>{{ user.name }}</td>
      <td>{{ user.email }}</td>
    </tr>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    axios.get("api/users").then((response) => {
      this.users = response.data;
    });
  },
};
</script>

<style>
</style>