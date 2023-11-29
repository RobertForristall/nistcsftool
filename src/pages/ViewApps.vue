<template>
  <div>
    <div class="header-container">
      <h1>Secure Software Development Framework App</h1>
      <h2>View Apps</h2>
    </div>
    <ListApps />
  </div>
</template>

<script>
import ListApps from "../components/ListApps.vue";
export default {
  name: "ViewApps",
  components: {},
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style></style>
