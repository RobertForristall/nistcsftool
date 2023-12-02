<template>
  <div>
    <div class="flex-container">
      <div class="flex-child-1">
        <Doughnut
          :options="chartOptions"
          :data="chartData"
          :chart-id="0"
          :height="250"
          :width="250"
          class="white-text"
        />
      </div>
      <div class="flex-child-2">
        <table class="white-text overflow-auto">
            <tr v-for="row in requirementsGrid">
                <td v-for="cell in row">
                    <b-button block :variant="nistRequirements[cell].variant" :class="'my-block-border ' + nistRequirements[cell].class" @click="handleRequirementClick">{{ cell }}</b-button>
                </td>
            </tr>
        </table>
      </div>
    </div>
    <div class="white-text margin-sides" v-if="store.selectedRequirementId !== ''">
        <h3>{{ nistRequirements[store.selectedRequirementId].Requirement }}</h3>
        <h4 class="manage-header">{{ nistRequirements[store.selectedRequirementId].Description }}</h4>
        <ul>
            <li v-for="item in nistRequirements[store.selectedRequirementId]['Related Controls'].split('\n')">
                {{ item }} {{ item !== "" ? `(${phaseMap[nistControls[item].Phase]})` : "" }}{{ item !== "" ? ": " + nistControls[item].Response : "" }}
            </li>
        </ul>
    </div>
  </div>
</template>

<script>
import { Doughnut } from "vue-chartjs";
import NistRequirements from "../NISTRequirements.json";

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
} from "chart.js";

import { requirementsGrid } from "../constants"

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);
export default {
  name: "Requirements",
  components: {},
  props: {
    nistControls: Object,
  },
  data() {
    let data = [0, 108];
    const isRequirementSatisfied = (control_ids) => {
        let returnValue = true;
        control_ids.forEach((control_id) => {
            if (control_id !== "" && this.$props.nistControls[control_id].Response !== "Satisfied") {
                returnValue = false;
            }
        })
        return returnValue;
    }
    Object.keys(NistRequirements).forEach((key) => {
        if (isRequirementSatisfied(NistRequirements[key]["Related Controls"].split("\n"))){
            data[0]++;
            data[1]--;
            NistRequirements[key].variant = "success";
            NistRequirements[key].class = "my-green-button";
        }
    })
    return {
      chartOptions: {
        responsive: false,
        maintainAspectRatio: false,
      },
      chartData: {
        labels: ["Satisfied", "Not Satisfied"],
        datasets: [
          {
            backgroundColor: ["#198754", "#dc3545"],
            data: data,
          },
        ],
      },
      currentRequirement: {
        Standard: "",
        Requirement: "",
        Description: "",
        "Related Controls": "",
        Phase: 2
      },
      nistRequirements: NistRequirements,
      nistControls: this.$props.nistControls,
      phaseMap: {
        1: "Planning Control",
        2: "Development Control",
        3: "Deployment Control"
      }
    };
  },
  methods: {
    handleRequirementClick: function (event) {
        store.selectedRequirementId = event.target.innerText
    }
  }
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style scoped>
.flex-container {
  width: 100%;
  height: 100%;
  padding: 20px;
  display: flex;
  flex-direction: row;
  flex-grow: 1;
}
.flex-child-1 {
  flex: auto;
  text-align: center;
  width: 20%;
}

.flex-child-2 {
  flex: auto;
  text-align: center;
  width: 80%;
}

canvas {
  padding: 0;
  margin: auto;
  display: block;
  width: 250px;
}

.white-text {
  color: white;
  max-height: 250px;
  display: block;
}

.my-block-border {
    width: 100%;
    height: 100%;
    border-radius: 0% !important;
}

.my-red-button {
    background-color: var(--bs-danger) !important;
}

.my-green-button {
    background-color: var(--bs-success) !important;
}

.margin-sides {
  margin-left: 25px;
  margin-right: 25px;
  margin-top: 30px;
  text-align: center;
}

.manage-header {
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}
</style>
