<template>
  <div>
    <PhaseTools
      v-if="store.phaseFlag === 1"
      v-bind:nist-controls="planningControls"
      v-bind:nist-requirements="NistRequirements"
      v-bind:phase="1"
      @change="handleComplianceChange"
    />
    <PhaseTools
      v-if="store.phaseFlag === 2"
      v-bind:nist-controls="developmentControls"
      v-bind:nist-requirements="NistRequirements"
      v-bind:phase="2"
      @change="handleComplianceChange"
    />
    <PhaseTools
      v-if="store.phaseFlag === 3"
      v-bind:nist-controls="deploymentControls"
      v-bind:nist-requirements="NistRequirements"
      v-bind:phase="3"
      @change="handleComplianceChange"
    />
    <Requirements v-if="store.phaseFlag === 4"
      v-bind:nist-controls="fullControls"/>
    <div v-if="store.phaseFlag === 0">
      <div class="margin-sides">
        <h5 class="white-text">Overall Control Compliance Progress</h5>
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
      <div class="margin-sides">
        <button
            type="button"
            style="margin-top: 50px;"
            @click="store.phaseFlag = 4"
          >
          Requirements Compliance
        </button>
        <button
            type="button"
            style="margin-top: 50px;"
            @click="store.phaseFlag = 5"
          >
          Assessment Tools
        </button>
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
            style="margin-top: 50px; margin-bottom: 50px"
            @click="store.phaseFlag = index + 1"
          >
            {{ stage }}
          </button>
          <Doughnut
            :options="chartOptions"
            :data="
              index === 0
                ? planningChartData
                : index === 1
                ? developmentChartData
                : deploymentChartData
            "
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
import PhaseTools from "../components/PhaseTools.vue";
import Requirements from "./Requirements.vue";

import NistControls from "../NISTControls.json";
import NistRequirements from "../NISTRequirements.json";

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
    PhaseTools,
    Requirements
  },
  mounted() {
    console.log(Object.keys(NistControls).length);
    console.log(Object.keys(NistRequirements).toString());
  },
  data() {
    let progressValues = [0, 0, 0, 110];
    store.controlComplianceValues.forEach((item) => {
      switch (item.compliance_value) {
        case 1:
          progressValues[0]++;
          progressValues[3]--;
          NistControls[item.control_id].Response = "Satisfied";
          break;
        case 2:
          progressValues[1]++;
          progressValues[3]--;
          NistControls[item.control_id].Response = "In Progress";
          break;
        case 3:
          progressValues[2]++;
          progressValues[3]--;
          NistControls[item.control_id].Response = "Not Satisfied";
          break;
        default:
          break;
      }
    });
    let planningControls = [];
    let planningDougnutData = [0, 0, 0, 28];
    let developmentControls = [];
    let developmentDougnutData = [0, 0, 0, 46];
    let deploymentControls = [];
    let deploymentDougnutData = [0, 0, 0, 36];
    const responseMap = {
      "Satisfied": 0,
      "In Progress": 1,
      "Not Satisfied": 2,
      "Unknown": 3,
    };
    Object.values(NistControls).forEach((item) => {
      switch (item.Phase) {
        case 1:
          planningControls.push(item);
          planningDougnutData[responseMap[item.Response]]++;
          planningDougnutData[3]--;
          break;
        case 2:
          developmentControls.push(item);
          developmentDougnutData[responseMap[item.Response]]++;
          developmentDougnutData[3]--;
          break;
        case 3:
          deploymentControls.push(item);
          deploymentDougnutData[responseMap[item.Response]]++;
          deploymentDougnutData[3]--;
          break;
        default:
          break;
      }
    });
    console.log(planningControls);
    console.log(developmentControls);
    console.log(deploymentControls);
    return {
      chartOptions: {
        responsive: false,
        maintainAspectRatio: false,
      },
      planningChartData: {
        labels: ["Satisfied", "In Progress", "Not Satisfied", "Unknown"],
        datasets: [
          {
            backgroundColor: ["#198754", "#ffc107", "#dc3545", "#6c757d"],
            data: planningDougnutData,
          },
        ],
      },
      developmentChartData: {
        labels: ["Satisfied", "In Progress", "Not Satisfied", "Unknown"],
        datasets: [
          {
            backgroundColor: ["#198754", "#ffc107", "#dc3545", "#6c757d"],
            data: developmentDougnutData,
          },
        ],
      },
      deploymentChartData: {
        labels: ["Satisfied", "In Progress", "Not Satisfied", "Unknown"],
        datasets: [
          {
            backgroundColor: ["#198754", "#ffc107", "#dc3545", "#6c757d"],
            data: deploymentDougnutData,
          },
        ],
      },
      progressValues: progressValues,
      planningControls: planningControls,
      developmentControls: developmentControls,
      deploymentControls: deploymentControls,
      fullControls: NistControls
    };
  },
  computed: {},
  methods: {
    getStages() {
      return [
        "Planning Controls",
        "Development Controls",
        "Deplyment Controls",
      ];
    },
    handleComplianceChange(event) {
      const newResposne = event.compliance_value === 1  ? "Satisfied"
        : (event.compliance_value === 2 ? "In Progress" 
        : (event.compliance_value === 3 ? "Not Satisfied" : "Unknown"))
      this.fullControls[event.control_id].Response = newResposne
      switch (event.phase) {
        case 1:
          this.planningControls = event.controls;
          this.planningChartData.datasets[0].data[event.compliance_value - 1]++;
          this.planningChartData.datasets[0].data[event.old_value - 1]--;
          this.progressValues[event.compliance_value - 1]++;
          this.progressValues[event.old_value - 1]--;
          break;
        case 2:
          this.developmentControls = event.controls;
          this.developmentChartData.datasets[0].data[event.compliance_value - 1]++;
          this.developmentChartData.datasets[0].data[event.old_value - 1]--;
          this.progressValues[event.compliance_value - 1]++;
          this.progressValues[event.old_value - 1]--;
          break;
        case 3:
          this.deploymentControls = event.controls;
          this.deploymentChartData.datasets[0].data[event.compliance_value - 1]++;
          this.deploymentChartData.datasets[0].data[event.old_value - 1]--;
          this.progressValues[event.compliance_value - 1]++;
          this.progressValues[event.old_value - 1]--;
          break;
        default:
          break;
      }
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
  margin-top: 30px;
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
