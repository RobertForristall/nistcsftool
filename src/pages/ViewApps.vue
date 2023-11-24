<template>
    <div id="app">
      <div class="main-container">
        <div class="header-container">
          <h1>View Apps</h1>
        </div>
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
  
  export default {
    name: 'ViewApps',
    components: {
  
    }
  }
  </script>

    <script setup>
    import { store } from '../store.js'
    </script>
  
  <style>

  </style>
  