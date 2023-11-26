<template>
  <div class="flex-container">
    <div class="flex-child">
      <h3>Control Name: {{ $props.control["Control ID"] }}</h3>
      <h4>Description:</h4>
      <p>{{ $props.control["Description"] }}</p>
    </div>
    <div class="flex-child">
      <div class="accordion" role="tablist">
        <b-card no-body class="mb-1">
          <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button block v-b-toggle.accordion-1 variant="info"
              >Comments</b-button
            >
          </b-card-header>
          <b-collapse id="accordion-1" accordion="my-accordion" role="tabpanel">
            <b-card-body class="h-50">
              <textarea class="w-100"> </textarea>
            </b-card-body>
          </b-collapse>
        </b-card>

        <b-card no-body class="mb-1">
          <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button block v-b-toggle.accordion-2 variant="info"
              >Files</b-button
            >
          </b-card-header>
          <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <p>Files content</p>
            </b-card-body>
          </b-collapse>
        </b-card>

        <b-card no-body class="mb-1">
          <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button block v-b-toggle.accordion-3 variant="info"
              >Related NIST CSF Requirements</b-button
            >
          </b-card-header>
          <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div class="accordion" role="tablist">
                <b-card
                  no-body
                  class="mb-1"
                  v-for="(req, index) in $props.control['NIST CSF'].split(
                    ' \n'
                  )"
                >
                  <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block v-b-toggle="req" variant="info"
                      >req</b-button
                    >
                  </b-card-header>
                  <b-collapse
                    :id="req"
                    accordion="req-accordion"
                    role="tabpanel"
                  >
                    <b-card>
                      <h4>ID: {{ NistRequirements[req].Requirement }}</h4>
                      <h5>
                        Goal:
                        {{ NistRequirements[req].Description.split(": ")[0] }}
                      </h5>
                      <p>
                        Description:
                        {{ NistRequirements[req].Description.split(": ")[2] }}
                      </p>
                    </b-card>
                  </b-collapse>
                </b-card>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
      </div>
    </div>
  </div>
</template>

<script>
import NistRequirements from "../NISTRequirements.json";
export default {
  name: "ViewApps",
  props: {
    control: Object,
  },
  components: {},
  methods: {
    getCollapseTag: function (index) {
      return `collapse-${index}`;
    },
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style>
.flex-container {
  display: flex;
}
.flex-child {
  flex: 50%;
}
</style>
