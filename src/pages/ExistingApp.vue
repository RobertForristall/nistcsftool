<template>
    <div id="app">
      <div class="main-container">
        <div class="header-container">
          <h1>Existing App</h1>
        </div>
        <ListApps v-if="store.currentAppId === -1"/>
        <AppHome v-if="store.currentAppId !== -1"/>
        <div>
          <button 
            type="button" 
            class="btn btn-primary" 
            style="margin-top: 100px;"
            @click="store.pageFlag = 0">Back</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import ListApps from '../components/ListApps.vue'
  import AppHome from '../components/AppHome.vue'

  export default {
    name: 'ExistingApp',
    components: {
      ListApps,
      AppHome
    },
    data: {
      apps: []
    },
  }
  </script>

    <script setup>
    import { store } from '../store.js'
    </script>
  
  <style>

  </style>
  