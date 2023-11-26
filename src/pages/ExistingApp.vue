<template>
  <div>
    <div class="header-container" v-if="store.currentAppId !== -1">
      <h1>Project - {{ this.currentApp.name }}</h1>
      <h2>Type - {{ this.currentApp.type }}</h2>
    </div>
    <div class="header-container" v-if="store.currentAppId === -1">
      <h1>Existing App</h1>
    </div>
    <ListApps v-if="store.currentAppId === -1" />
    <AppHome v-if="store.currentAppId !== -1" />
    <div>
      <button
        type="button"
        class="btn btn-primary"
        style="margin-top: 100px"
        @click="this.onBackClick"
      >
        Back
      </button>
    </div>
  </div>
</template>

<script>
import ListApps from "../components/ListApps.vue";
import AppHome from "../components/AppHome.vue";

export default {
  name: "ExistingApp",
  components: {
    ListApps,
    AppHome,
  },
  data: {
    apps: [],
  },
  computed: {
    currentApp: function () {
      const isMatch = (element) => element.id === store.currentAppId;
      const index = store.userApps.findIndex(isMatch);
      return store.userApps.at(index);
    },
  },
  methods: {
    onBackClick: function (event) {
      if (store.currentAppId === -1) {
        store.pageFlag = 0;
      } else {
        if (store.phaseFlag === 0) {
          store.currentAppId = -1;
        } else if (store.phaseFlag === 1) {
          store.phaseFlag = 0;
        }
      }
    },
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style></style>
