<template>
  <div>
    <div class="header-container">
      <h1>Secure Software Development Framework App</h1>
    </div>
    <div>
      <button
        type="button"
        class="btn btn-primary"
        style="margin-top: 100px"
        @click="store.pageFlag = 1"
      >
        Begin New App Development
      </button>
    </div>
    <div>
      <button
        type="button"
        class="btn btn-primary"
        style="margin-top: 50px"
        @click="onClickExistingApps"
      >
        Continue With Existing Development
      </button>
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

<style></style>
