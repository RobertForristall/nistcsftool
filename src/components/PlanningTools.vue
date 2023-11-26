<template>
  <div>
    <ViewControl
      v-if="store.selectedControlId !== ''"
      v-bind:control="NistControls[store.selectedControlId]"
    />
    <div v-if="store.selectedControlId === ''">
      <h5>Planning Phase</h5>
      <b-progress :value="30" :max="100" show-progress animated></b-progress>
      <!-- <b-table sticky-header striped hover :items="$props.nistControl"> -->
      <b-table
        sticky-header
        striped
        hover
        :items="Object.values(NistControls)"
        :fields="this.fields"
        class="my-table-class"
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
            data.value.length > 100
              ? data.value.substring(0, 100) + "..."
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
  name: "PlanningTools",
  props: {
    nistControls: Array,
    nistRequirements: Object,
  },
  components: {
    ViewControl,
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

<style>
.row {
  height: 120px;
}
.my-table-class {
  max-height: 400px !important;
}
</style>
