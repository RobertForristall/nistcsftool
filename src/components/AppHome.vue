<template>
  <div>
    <PlanningTools
      v-if="store.phaseFlag === 1"
      v-bind:nist-controls="Object.values(NistControls)"
      v-bind:nist-requirements="NistRequirements"
    />
    <div v-if="store.phaseFlag === 0">
      <h5>Overall Compliance Progress</h5>
      <b-progress :value="30" :max="100" show-progress animated></b-progress>
      <div>
        <button
          type="button"
          class="btn btn-primary"
          style="margin-top: 100px"
          @click="store.phaseFlag = 1"
        >
          Planning Tools
        </button>
      </div>
      <div>
        <button
          type="button"
          class="btn btn-primary"
          style="margin-top: 50px"
          @click=""
        >
          Development Tools
        </button>
      </div>
      <div>
        <button
          type="button"
          class="btn btn-primary"
          style="margin-top: 50px"
          @click=""
        >
          Assessment Tools
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import PlanningTools from "./PlanningTools.vue";

import NistControls from "../NISTControls.json";
import NistRequirements from "../NISTRequirements.json";

export default {
  name: "AppHome",
  components: {
    PlanningTools,
  },
  mounted() {
    console.log(NistControls);
    console.log(NistRequirements);
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style></style>
