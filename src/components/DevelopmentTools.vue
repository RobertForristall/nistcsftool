<template>
  <div>
    <div class="margin-sides">
      <h5 class="white-text">Development Phase Compliance Progress</h5>
      <b-progress :value="30" :max="100" show-progress animated></b-progress>
    </div>
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

<style scoped>
.white-text {
  color: white;
}
.margin-sides {
  margin-left: 25px;
  margin-right: 25px;
  margin-top: 50px;
  text-align: center;
}
</style>
