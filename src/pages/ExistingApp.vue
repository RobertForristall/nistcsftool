<template>
  <div>
    <div class="header-container">
      <h1>Secure Software Development Framework App</h1>
      <h2>
        Project: {{ this.currentApp.name }} | Type: {{ this.currentApp.type }}
      </h2>
    </div>
    <AppHome />
    <div v-if="store.phaseFlag !== 0" class="center">
      <button
        type="button"
        class="btn btn-primary bottom-btn"
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
          if (store.selectedControlId === "") {
            store.phaseFlag = 0;
          } else {
            store.selectedControlId = "";
          }
        } else if (store.phaseFlag > 1) {
          // TODO Finish back mappings for these pages
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

<style scoped>
.center {
  align-content: center;
  display: flex;
  bottom: 50px;
  width: 100%;
  justify-content: center;
}

.bottom-btn {
  margin-left: auto;
  margin-right: auto;
  display: block;
}
</style>
