<template>
  <div>
    <ViewControl
      v-if="store.selectedControlId !== ''"
      v-bind:control="NistControls[store.selectedControlId]"
      @change="handleComplianceChange"
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
      progressMax: this.$props.nistControls.length,
      phase: this.$props.phase
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
  methods: {
    handleComplianceChange: function (event) {
      console.log("In Event Handler for emitted event")
      let index = this.nistControls.findIndex(x => x["Control ID"] === event.control_id);
      const responseMap = {
      "Satisfied": 0,
      "In Progress": 1,
      "Not Satisfied": 2,
      "Unknown": 3
      }
      let oldValue = responseMap[this.nistControls[index].Response];
      switch(event.compliance_value) {
        case 1:
          this.progressValues[0]++
          this.progressValues[responseMap[this.nistControls[index].Response]]--
          this.nistControls[index].Response = "Satisfied"
          break;
        case 2:
          this.progressValues[1]++
          this.progressValues[responseMap[this.nistControls[index].Response]]--
          this.nistControls[index].Response = "In Progress"
          break;
        case 3:
          this.progressValues[2]++
          this.progressValues[responseMap[this.nistControls[index].Response]]--
          this.nistControls[index].Response = "Not Satisfied"
          break;
        default:
          break;
      }
      this.$emit('change', {...event, phase: this.phase, controls: this.nistControls, old_value: oldValue+1})
    }
  }
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
