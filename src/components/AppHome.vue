<template>
    <div id="app">
      <div class="main-container">
        <div class="header-container">
          <h1>App Home {{ store.currentAppId }}</h1>
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
  
  export default {
    name: 'AppHome',
    components: {
  
    }
  }
  </script>

    <script setup>
    import { store } from '../store.js'
    </script>
  
  <style>

  </style>
  