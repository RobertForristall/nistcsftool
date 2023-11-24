<template>
    <div id="app">
      <div class="main-container">
        <div class="header-container">
          <h1>Secure Software Development Framework App</h1>
        </div>
        <div>
          <button 
            type="button" 
            class="btn btn-primary" 
            style="margin-top: 100px;"
            @click="store.pageFlag = 1">Begin New App Development</button>
        </div>
        <div>
          <button 
            type="button" 
            class="btn btn-primary" 
            style="margin-top: 50px;"
            @click="store.pageFlag = 2">Continue With Existing Development</button>
        </div>
        <div>
          <button 
            type="button" 
            class="btn btn-primary" 
            style="margin-top: 50px;"
            @click="store.pageFlag = 3">View All Developing Apps</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  
  export default {
    name: 'Home',
    components: {
  
    },
    mounted() {
      try {
        store.currentAppId = -1
      } catch (e) {
        console.error(e)
      }
    },
  }
  </script>

    <script setup>
    import { store } from '../store.js'
    </script>
  
  <style>

  </style>
  