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
      <div class="margin-sides">
        <h5 class="white-text">Overall Compliance Progress</h5>
        <b-progress :value="30" :max="100" show-progress animated></b-progress>
      </div>
      <div class="flex-container">
        <div
          class="flex-child"
          v-for="(stage, index) in [
            'Planning Controls',
            'Development Controls',
            'Deployment Controls',
          ]"
        >
          <button
            type="button"
            style="margin-top: 100px; margin-bottom: 50px"
            @click="store.phaseFlag = index + 1"
          >
            {{ stage }}
          </button>
          <Doughnut
            :options="chartOptions"
            :data="chartData"
            :chart-id="index"
            :height="250"
            :width="250"
          />
        </div>
      </div>
      <!-- <div>
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
      </div> -->
    </div>
  </div>
</template>

<script>
import PlanningTools from "./PlanningTools.vue";
import DevelopmentTools from "./DevelopmentTools.vue";
import AssessmentTools from "./AssessmentTools.vue";

import NistControls from "../NISTControls.json";
// import NistRequirements from "../NISTRequirements.json";

import { Doughnut } from "vue-chartjs";

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
} from "chart.js";

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

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
  data() {
    return {
      chartOptions: {
        responsive: false,
        maintainAspectRatio: false,
      },
      chartData: {
        labels: ["Satisfied", "In Progress", "Not Satisfied", "Unknown"],
        datasets: [
          {
            backgroundColor: ["#41B883", "#E46651", "#00D8FF", "#DD1B16"],
            data: [40, 20, 80, 10],
          },
        ],
      },
    };
  },
  methods: {
    getStages() {
      return [
        "Planning Controls",
        "Development Controls",
        "Deplyment Controls",
      ];
    },
  },
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
.flex-container {
  width: 100%;
  height: 100%;
  padding: 20px;
  display: flex;
  flex-direction: row;
  flex-grow: 1;
}
.flex-child {
  flex: auto;
  text-align: center;
}

canvas {
  padding: 0;
  margin: auto;
  display: block;
  width: 250px;
}
</style>
