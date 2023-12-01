<template>
  <div id="content">
    <NcAppNavigation>
      <template #list>
        <NcAppNavigationItem
          :key="t('nistcsfcomplianceassistant', 'Home')"
          :title="t('nistcsfcomplianceassistant', 'Home')"
          :class="{ active: false }"
          @click="store.pageFlag = 0"
        >
          <template #icon>
            <HomeIcon :size="20" />
          </template>
        </NcAppNavigationItem>
        <NcAppNavigationItem
          :key="t('nistcsfcomplianceassistant', 'New App')"
          :title="t('nistcsfcomplianceassistant', 'New App')"
          :class="{ active: false }"
          @click="store.pageFlag = 1"
        >
          <template #icon>
            <Pencil :size="20" />
          </template>
        </NcAppNavigationItem>
        <NcAppNavigationItem
          :key="t('nistcsfcomplianceassistant', 'View Apps')"
          :title="t('nistcsfcomplianceassistant', 'View Apps')"
          :class="{ active: false }"
          @click="store.pageFlag = 3"
        >
          <template #icon>
            <ListBox :size="20" />
          </template>
        </NcAppNavigationItem>
        <NcAppNavigationItem
          name="Existing App"
          :allowCollapse="true"
          :open="false"
          :key="t('nistcsfcomplianceassistant', 'Existing Apps')"
        >
          <template #icon>
            <Cog :size="20" />
          </template>
          <template #counter>
            <NcCounterBubble>
              {{ store.userApps.length > 99 ? "99+" : store.userApps.length }}
            </NcCounterBubble>
          </template>
          <template>
            <NcAppNavigationItem
              v-for="app in store.userApps"
              :key="app.id"
              :title="t('nistcsfcomplianceassistant', app.name)"
              :class="{ active: false }"
              @click="clickExistingApp(app.id)"
            >
              <template #icon>
                <Pencil :size="20" />
              </template>
            </NcAppNavigationItem>
          </template>
        </NcAppNavigationItem>
      </template>
    </NcAppNavigation>
    <NcAppContent>
      <!-- Load each page of the application based on the current state-->
      <Home v-if="store.pageFlag === 0" />
      <NewApp v-if="store.pageFlag === 1" />
      <ExistingApp v-if="store.pageFlag === 2" />
      <ViewApps v-if="store.pageFlag === 3" />
    </NcAppContent>
  </div>
</template>

<script>
// Component imports
import Home from "./pages/Home.vue";
import NewApp from "./pages/NewApp.vue";
import ExistingApp from "./pages/ExistingApp.vue";
import ViewApps from "./pages/ViewApps.vue";

import NcAppNavigation from "@nextcloud/vue/dist/Components/NcAppNavigation";
import NcAppContent from "@nextcloud/vue/dist/Components/NcAppContent";
import NcAppNavigationItem from "@nextcloud/vue/dist/Components/NcAppNavigationItem";
import NcCounterBubble from "@nextcloud/vue/dist/Components/NcCounterBubble";

import Pencil from "vue-material-design-icons/Pencil";
import ListBox from "vue-material-design-icons/ListBox";
import Cog from "vue-material-design-icons/Cog";
import HomeIcon from "vue-material-design-icons/Home";

import axios from "@nextcloud/axios";
import { generateUrl } from "@nextcloud/router";

// Define Vue component
export default {
  name: "App",
  components: {
    Home,
    NewApp,
    ExistingApp,
  },
  async beforeCreate() {
    try {
      const response = await axios.get(generateUrl("/apps/nistcsftool/apps"));
      store.userApps = response.data;
    } catch (e) {
      console.error(e);
    }
  },
  methods: {
    async clickExistingApp(id) {
      try {
        const response = await axios.get(
          generateUrl("/apps/nistcsftool/controls?app_id=" + id)
        );
        console.log(response.data);
        store.controlComplianceValues = response.data;
        store.selectedControlId = "";
        store.phaseFlag = 0;
        store.currentAppId = id;
        store.pageFlag = 2;
      } catch (e) {
        console.error(e);
      }
    },
  },
};
</script>

<script setup>
import { store } from "./store.js";
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.main-container {
  background-color: aliceblue;
  width: 1200px;
  height: 800px;
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.header-container {
  /* background-color: rgba(146, 202, 92, 255); */
  background-color: var(--color-primary-element);
  color: white;
  text-align: center;
  margin: auto;
  /* position: absolute; */
  /* top: 0%; */
  height: 100px;
  width: 100%;
  border: 1px solid black;
}

.my-btn-class {
  background-color: rgba(146, 202, 92, 255);
  color: white;
}

#app-content > div {
  width: 100%;
  height: 100%;
  padding: 20px;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

/* .btn {
  background-color: rgba(146,202,92,255) !important;
  color: white !important;
} */

@import "~bootstrap/dist/css/bootstrap.css";
</style>
