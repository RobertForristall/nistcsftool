<template>
  <div>
    <b-table sticky-header striped hover :items="store.userApps">
      <template #cell(name)="data">
        <b-button
          variant="link"
          @click="store.currentAppId = getIdFromName(data.value)"
          >{{ data.value }}</b-button
        >
      </template>
    </b-table>
  </div>
</template>

<script>
export default {
  name: "ListApps",
  data: {
    apps: [],
  },
  components: {},
  methods: {
    getIdFromName(name) {
      const isMatch = (element) => element.name === name;
      const index = store.userApps.findIndex(isMatch);
      return store.userApps.at(index).id;
    },
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style></style>
