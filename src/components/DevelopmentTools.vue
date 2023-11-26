<template>
  <div>
    <h5>Development Phase</h5>
    <b-progress :value="30" :max="100" show-progress animated></b-progress>
    <!-- <b-table sticky-header striped hover :items="$props.nistControl"> -->
  </div>
</template>

<script>
export default {
  name: "DevelopmentTools",
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style></style>
