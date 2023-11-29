<template>
  <div>
    <ul>
      <NcListItem
        v-for="app in store.userApps"
        :key="app.id"
        :title="app.name"
        :bold="false"
        :details="'1h'"
        class="white-text"
      >
        <template #icon>
          <Cog :size="20" />
        </template>
        <template #subname class="white-text">
          {{ app.type }}
        </template>
      </NcListItem>
    </ul>
  </div>
</template>

<script>
import NcListItem from "@nextcloud/vue/dist/Components/NcListItem";
import Cog from "vue-material-design-icons/Cog.vue";
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

<style scoped>
.white-text {
  color: white;
}
</style>
