<template>
  <div>
    <ViewControl
      v-if="store.selectedControlId !== ''"
      v-bind:control="NistControls[store.selectedControlId]"
    />
    <div v-if="store.selectedControlId === ''">
      <div class="margin-sides">
        <h5 class="white-text">{{ phaseTitle }} Phase Compliance Progress</h5>
        <b-progress class="mt-2" :max="progressMax" show-value>
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
      <!-- <b-table sticky-header striped hover :items="$props.nistControl"> -->
      <b-table
        sticky-header
        striped
        hover
        :items="nistControls"
        :fields="this.fields"
        class="my-table-class"
        :dark="true"
      >
        <template #cell(Control-ID)="data">
          <b-button
            variant="link"
            @click="store.selectedControlId = data.item['Control ID']"
            >{{ data.item["Control ID"] }}</b-button
          >
        </template>
        <template #cell(Description)="data">
          {{
            data.value.length > 120
              ? data.value.substring(0, 120) + "..."
              : data.value
          }}
        </template>
      </b-table>
    </div>
  </div>
</template>

<script>
import NistControls from "../NISTControls.json";
import ViewControl from "./ViewControl.vue";
export default {
  name: "PhaseTools",
  props: {
    nistControls: Array,
    nistRequirements: Object,
    phase: Number
  },
  components: {
    ViewControl,
  },
  data() {
    let progressValues = [0, 0, 0, this.$props.nistControls.length];
    this.$props.nistControls.forEach((item) => {
      switch (item.Response) {
        case "Satisfied":
          progressValues[0]++;
          progressValues[3]--;
          break;
        case "In Progress":
          progressValues[1]++;
          progressValues[3]--;
          break;
        case "Not Satisfied":
          progressValues[2]++;
          progressValues[3]--;
          break;
        default:
          break;
      }
    });
    const phaseTitle = (this.$props.phase === 1) ? "Planning"
      : ((this.$props.phase === 2) ? "Development" : "Deployment");
    return {
      nistControls: this.$props.nistControls,
      progressValues: progressValues,
      phaseTitle: phaseTitle,
      progressMax: this.$props.nistControls.length
    }
  },
  computed: {
    currentApp: function () {
      const isMatch = (element) => element.id === store.currentAppId;
      const index = store.userApps.findIndex(isMatch);
      return store.userApps.at(index);
    },
    fields: function () {
      return ["Control-ID", "Description", "Response"];
    },
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style scoped>
.row {
  height: 120px;
}
.my-table-class {
  max-height: 400px !important;
  margin-left: 25px;
  margin-right: 25px;
  margin-top: 50px;
}
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