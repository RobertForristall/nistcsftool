<template>
  <div>
    <div class="margin-sides">
      <h5 class="white-text">Deployment Phase Compliance Progress</h5>
      <b-progress class="mt-2" :max="110" show-value>
          <b-progress-bar
            :value="110 * (3 / 10)"
            variant="success"
          ></b-progress-bar>
          <b-progress-bar
            :value="110 * (2.5 / 10)"
            variant="warning"
          ></b-progress-bar>
          <b-progress-bar
            :value="110 * (1.5 / 10)"
            variant="danger"
          ></b-progress-bar>
          <b-progress-bar
            :value="110 * (3 / 10)"
            variant="secondary"
          ></b-progress-bar>
        </b-progress>
    </div>
    <!-- <b-table sticky-header striped hover :items="$props.nistControl"> -->
  </div>
</template>

<script>
export default {
  name: "AssessmentTools",
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
