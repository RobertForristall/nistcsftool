<template>
    <div id="app">
      <PlanningTools v-if="store.phaseFlag === 1" v-bind:nist-controls ="Object.values(NistControls)" v-bind:nist-requirements="NistRequirements"/>
      <div class="main-container" v-if="store.phaseFlag === 0">
        <div class="header-container">
          <h1>Project - {{ this.currentApp.name }}</h1>
          <h2>Type - {{ this.currentApp.type }}</h2>
        </div>
        <h5>Overall Compliance Progress</h5>
        <b-progress :value="30" :max="100" show-progress animated></b-progress>
        <div>
          <button 
            type="button" 
            class="btn btn-primary" 
            style="margin-top: 100px;"
            @click="store.phaseFlag = 1">Planning Tools</button>
        </div>
        <div>
          <button 
            type="button" 
            class="btn btn-primary" 
            style="margin-top: 50px;"
            @click="">Development Tools</button>
        </div>
        <div>
          <button 
            type="button" 
            class="btn btn-primary" 
            style="margin-top: 50px;"
            @click="">Assessment Tools</button>
        </div>
        <div>
          <button 
            type="button" 
            class="btn btn-primary" 
            style="margin-top: 100px;"
            @click="store.currentAppId = -1">Back</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  
  import PlanningTools from './PlanningTools.vue';

  import NistControls from '../NISTControls.json'
  import NistRequirements from '../NISTRequirements.json'

  export default {
    name: 'AppHome',
    components: {
      PlanningTools
    },
    computed: {
      currentApp: function () {
        const isMatch = (element) => element.id === store.currentAppId 
        const index = store.userApps.findIndex(isMatch)
        return store.userApps.at(index)
      }
    },
    mounted() {
      console.log(NistControls)
      console.log(NistRequirements)
    }
  }
  </script>

    <script setup>
    import { store } from '../store.js'
    </script>
  
  <style>

  </style>
  