<template>
  <div>
    <PlanningTools
      v-if="store.phaseFlag === 1"
      v-bind:nist-controls="Object.values(NistControls)"
      v-bind:nist-requirements="NistRequirements"
    />
    <DevelopmentTools v-if="store.phaseFlag === 2" />
    <AssessmentTools v-if="store.phaseFlag === 3" />
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
          @click="store.phaseFlag = 2"
        >
          Development Tools
        </button>
      </div>
      <div>
        <button
          type="button"
          class="btn btn-primary"
          style="margin-top: 50px"
          @click="store.phaseFlag = 3"
        >
          Assessment Tools
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import PlanningTools from "./PlanningTools.vue";
import DevelopmentTools from "./DevelopmentTools.vue";
import AssessmentTools from "./AssessmentTools.vue";

import NistControls from "../NISTControls.json";
// import NistRequirements from "../NISTRequirements.json";

export default {
  name: "AppHome",
  components: {
    PlanningTools,
    DevelopmentTools,
    AssessmentTools,
  },
  mounted() {
    console.log(NistControls);
    // console.log(NistRequirements);
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style></style>
