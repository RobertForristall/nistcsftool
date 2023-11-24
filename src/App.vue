<template>
  <div id="app">
    <div class="main-container">
      <Home v-if="store.pageFlag === 0"/>
      <NewApp v-if="store.pageFlag === 1"/>
      <ExistingApp v-if="store.pageFlag === 2"/>
    </div>
  </div>
</template>

<script>

import Home from './pages/Home.vue'
import NewApp from './pages/NewApp.vue'
import ExistingApp from './pages/ExistingApp.vue'

export default {
  name: 'App',
  components: {
    Home,
    NewApp,
    ExistingApp
  }
}
</script>

<script setup>
import { store } from './store.js'
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
  width: 600px;
  height: 600px;
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.header-container {
  background-color: forestgreen;
  text-align: center;
  /* position: absolute; */
  /* top: 0%; */
  height: 100px; 
  width: 100%;
  border: 1px solid black;
}

@import'~bootstrap/dist/css/bootstrap.css';
</style>
