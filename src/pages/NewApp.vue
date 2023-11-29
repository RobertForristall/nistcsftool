<template>
  <div>
    <div class="header-container">
      <h1>Secure Software Development Framework App</h1>
      <h2>New App</h2>
    </div>
    <form @submit.prevent="submit" class="margin-sides">
      <div class="mb-3">
        <NcTextField
          :value.sync="name"
          label="New App's Name"
          trailing-button-icon="close"
          :show-trailing-button="name !== ''"
          @trailing-button-click="clearName"
          class="margin-top"
        >
          <Magnify :size="20" />
        </NcTextField>
        <div id="nameHelp" class="form-text white-text">
          Name of the application who's compliance will be tracked
        </div>
      </div>
      <div class="mb-3">
        <NcTextField
          :value.sync="type"
          label="New App's Type"
          trailing-button-icon="close"
          :show-trailing-button="type !== ''"
          @trailing-button-click="clearType"
          class="margin-top"
        >
          <Magnify :size="20" />
        </NcTextField>
        <div id="nameHelp" class="form-text white-text">
          Type of the application who's compliance will be tracked
        </div>
      </div>
      <div class="center">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
import NcTextField from "@nextcloud/vue/dist/Components/NcTextField.js";
import Magnify from "vue-material-design-icons/Magnify";
import axios from "@nextcloud/axios";
import { generateUrl } from "@nextcloud/router";

export default {
  name: "NewApp",
  data: {
    name: "",
    type: "",
  },
  components: {},
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
    clearName() {
      this.name = "";
    },
    clearType() {
      this.type = "";
    },
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style scoped>
.margin-top {
  margin-top: 50px;
}
.white-text {
  color: white;
}
.margin-sides {
  margin-left: 25px;
  margin-right: 25px;
}
.center {
  align-content: center;
}
</style>
