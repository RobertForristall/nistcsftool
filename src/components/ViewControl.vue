<template>
  <div class="flex-container">
    <div class="flex-child">
      <h3>Control Name: {{ $props.control["Control ID"] }}</h3>
      <h4>Description:</h4>
      <p>{{ $props.control["Description"] }}</p>
    </div>
    <div class="flex-child">
      <h3>Related NIST CSF Requirements:</h3>
      <div v-for="(req, index) in $props.control['NIST CSF'].split(' \n')">
        <b-button v-b-toggle="req" variant="primary">{{ req }}</b-button>
        <b-collapse :id="req" class="mt-2">
          <b-card>
            <h5>{{ NistRequirements[req].Requirement }}</h5>
            <p>{{ NistRequirements[req].Description }}</p>
          </b-card>
        </b-collapse>
      </div>
    </div>
  </div>
</template>

<script>
import NistRequirements from "../NISTRequirements.json";
export default {
  name: "ViewApps",
  props: {
    control: Object,
  },
  components: {},
  methods: {
    getCollapseTag: function (index) {
      return `collapse-${index}`
    }
  }
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style>
.flex-container {
  display: flex;
}
.flex-child {
  flex: 50%;
}
</style>
