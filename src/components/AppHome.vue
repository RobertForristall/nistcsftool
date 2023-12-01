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
        <b-progress class="mt-2" :max="110" show-value>
          <b-progress-bar
            :value="progressValues[0]"
            variant="success"
          ></b-progress-bar>
          <b-progress-bar
            :value="progressValues[1]"
            variant="warning"
          ></b-progress-bar>
          <b-progress-bar
            :value="progressValues[2]"
            variant="danger"
          ></b-progress-bar>
          <b-progress-bar
            :value="progressValues[3]"
            variant="secondary"
          ></b-progress-bar>
        </b-progress>
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
            class="white-text"
          />
        </div>
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
    console.log(Object.keys(NistControls).length);
    // console.log(NistRequirements);
  },
  data() {
    let progressValues = [0, 0, 0, 0];
    Object.keys(NistControls).forEach((key) => {
      switch (NistControls[key].Response) {
        case "Satisfied":
          progressValues[0]++;
          break;
        case "In Progress":
          progressValues[1]++;
          break;
        case "Not Satisfied":
          progressValues[2]++;
          break;
        case "Unknown":
          progressValues[3]++;
          break;
        default:
          break;
      }
    });
    return {
      chartOptions: {
        responsive: false,
        maintainAspectRatio: false,
      },
      chartData: {
        labels: ["Satisfied", "In Progress", "Not Satisfied", "Unknown"],
        datasets: [
          {
            backgroundColor: ["#198754", "#ffc107", "#dc3545", "#6c757d"],
            data: [40, 20, 80, 10],
          },
        ],
      },
      progressValues: progressValues,
    };
  },
  computed: {
    overallProgress() {
      let progressValues = [0, 0, 0, 0];
      Object.keys(NistControls).forEach((key) => {
        switch (NistControls[key].Response) {
          case 1:
            progressValues[0]++;
            break;
          case 2:
            progressValues[1]++;
            break;
          case 3:
            progressValues[2]++;
            break;
          case 4:
            progressValues[3]++;
            break;
          default:
            break;
        }
      });
      return progressValues;
    },
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
