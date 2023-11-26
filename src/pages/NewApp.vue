<template>
  <div>
    <div class="header-container">
      <h1>New App</h1>
    </div>
    <form @submit.prevent="submit">
      <div class="mb-3">
        <label for="nameOfNewApp" class="form-label">Name of New App</label>
        <input
          type="text"
          class="form-control"
          id="nameOfNewApp"
          aria-describedby="nameHelp"
          v-model="name"
        />
        <div id="nameHelp" class="form-text">
          Name of the application who's compliance will be tracked
        </div>
      </div>
      <div class="mb-3">
        <label for="typeOfNewApp" class="form-label">Type of New App</label>
        <input
          type="text"
          class="form-control"
          id="typeOfNewApp"
          v-model="type"
        />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div>
      <button
        type="button"
        class="btn btn-primary"
        style="margin-top: 100px"
        @click="store.pageFlag = 0"
      >
        Back
      </button>
    </div>
  </div>
</template>

<script>
import axios from "@nextcloud/axios";
import { generateUrl } from "@nextcloud/router";

export default {
  name: "NewApp",
  data: {
    name: "",
    type: "",
  },
  components: {},
  // async mounted() {
  //   try {
  //     const response = await axios.get(generateUrl('/apps/nistcsftool/apps'))
  //     console.log(response.data)
  //   } catch (e) {
  //     console.error(e)
  //   }
  // },
  methods: {
    async submit(e) {
      try {
        const postAppResponse = await axios.post(
          generateUrl("/apps/nistcsftool/apps"),
          { name: this.name, type: this.type }
        );
        console.log(postAppResponse.data);
        store.currentAppId = postAppResponse.data.id;
        if (store.userApps.length == 0) {
          const getAppsResponse = await axios.get(
            generateUrl("/apps/nistcsftool/apps")
          );
          store.userApps = getAppsResponse.data;
        } else {
          store.userApps.push(postAppResponse.data);
        }
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
