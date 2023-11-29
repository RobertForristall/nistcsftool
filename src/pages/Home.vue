<template>
  <div>
    <div class="header-container">
      <h1>Secure Software Development Framework App</h1>
      <h2>Home</h2>
    </div>
    <div>
      <p>Please use the leftside navigation bar to do the following:</p>
      <ul>
        <li>
          Start tracking the development of a new App by clicking "New App"
        </li>
        <li>
          View a detailed list of all tracked Apps by clicking "View Apps"
        </li>
        <li>
          Select and continue tracking on an existing App by clicking "Existing
          Apps" and selecting the desired app
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "@nextcloud/axios";
import { generateUrl } from "@nextcloud/router";

export default {
  name: "Home",
  components: {},
  mounted() {
    try {
      store.currentAppId = -1;
    } catch (e) {
      console.error(e);
    }
  },
  methods: {
    onClickExistingApps: async function (event) {
      try {
        const response = await axios.get(generateUrl("/apps/nistcsftool/apps"));
        store.userApps = response.data;
        store.pageFlag = 2;
      } catch (e) {
        console.error(e);
      }
    },
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style scoped>
div {
  color: white;
}
</style>
