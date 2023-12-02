<template>
  <div class="white-text">
    <div class="flex-container" style="max-height: 400px">
      <div class="flex-child">
        <h3>Control Name: {{ $props.control["Control ID"] }}</h3>
        <h4>Description:</h4>
        <p>{{ $props.control["Description"] }}</p>
        <div style="margin-top: 50px">
          <b-form-group
            label="Current compliance of control:"
            v-slot="{ ariaDescribedby }"
          >
            <b-form-radio-group
              v-model="selected"
              buttons
              @change="onComplianceSelection"
            >
              <b-form-radio
                v-for="option in options"
                :key="option.text"
                :value="option.value"
                :disabled="option.disabled"
                :button-variant="option.buttonVariant"
              >
                {{ option.text }}
              </b-form-radio>
            </b-form-radio-group>
          </b-form-group>
        </div>
      </div>
      <div class="flex-child">
        <div class="accordion" role="tablist">
          <b-card no-body class="mb-1" bg-variant="dark">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button
                block
                v-b-toggle.accordion-1
                variant="info"
                class="accordian-button"
                >Comments</b-button
              >
            </b-card-header>
            <b-collapse
              id="accordion-1"
              accordion="my-accordion"
              role="tabpanel"
            >
              <b-card-body class="h-50">
                <textarea class="w-100" v-model="comment" placeholder="Add a comment"></textarea>
              </b-card-body>
            </b-collapse>
          </b-card>

          <b-card no-body class="mb-1" bg-variant="dark">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button
                block
                v-b-toggle.accordion-2
                variant="info"
                class="accordian-button"
                >Files</b-button
              >
            </b-card-header>
            <b-collapse
              id="accordion-2"
              accordion="my-accordion"
              role="tabpanel"
            >
              <b-card-body>
                <div class="mb-3">
                  <label for="formFile" class="form-label"
                    >Default file input example</label
                  >
                  <input class="form-control" type="file" id="formFile" />
                </div>
              </b-card-body>
            </b-collapse>
          </b-card>

          <b-card no-body class="mb-1" bg-variant="dark">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button
                block
                v-b-toggle.accordion-3
                variant="info"
                class="accordian-button"
                >Related NIST CSF Requirements</b-button
              >
            </b-card-header>
            <b-collapse
              id="accordion-3"
              accordion="my-accordion"
              role="tabpanel"
            >
              <b-card-body>
                <div class="accordion" role="tablist" style="max-height: 400px">
                  <b-card
                    no-body
                    class="mb-1"
                    bg-variant="dark"
                    v-for="(req, index) in $props.control['NIST CSF'].split(
                      ' \n'
                    )"
                  >
                    <b-card-header header-tag="header" class="p-1" role="tab">
                      <b-button
                        block
                        v-b-toggle="req"
                        variant="info"
                        class="accordian-button"
                        >{{ req }}</b-button
                      >
                    </b-card-header>
                    <b-collapse
                      :id="req"
                      accordion="req-accordion"
                      role="tabpanel"
                    >
                      <b-card bg-variant="dark">
                        <h4 class="white-text">
                          ID: {{ NistRequirements[req].Requirement }}
                        </h4>
                        <h5 class="white-text">
                          Goal:
                          {{ NistRequirements[req].Description.split(": ")[0] }}
                        </h5>
                        <p class="white-text">
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
  </div>
</template>

<script>
import axios from "@nextcloud/axios";
import { generateUrl } from "@nextcloud/router";
import NistRequirements from "../NISTRequirements.json";
export default {
  name: "ViewApps",
  props: {
    control: Object,
  },
  components: {},
  data() {
    const responseMap = {
      Satisfied: 1,
      "In Progress": 2,
      "Not Satisfied": 3,
      Unknown: 4,
    };
    return {
      selected: responseMap[this.$props.control.Response],
      options: [
        {
          text: "Satisfied",
          value: 1,
          disabled: false,
          buttonVariant: "outline-success",
        },
        {
          text: "In Progress",
          value: 2,
          disabled: false,
          buttonVariant: "outline-warning",
        },
        {
          text: "Not Satisfied",
          value: 3,
          disabled: false,
          buttonVariant: "outline-danger",
        },
        {
          text: "Unknown",
          value: 4,
          disabled: false,
          buttonVariant: "outline-secondary",
        },
      ],
      comment: this.$props.control.Comment
    };
  },
  methods: {
    getCollapseTag: function (index) {
      return `collapse-${index}`;
    },
    onComplianceSelection: async function () {
      console.log("saving compliance level: " + this.selected);
      try {
        const postControlResponse = await axios.post(
          generateUrl("/apps/nistcsftool/controls"),
          {
            control_id: store.selectedControlId,
            app_id: store.currentAppId,
            compliance_value: this.selected,
            comment: this.comment
          }
        );
        console.log(postControlResponse.data);
        this.$emit("change", {
          control_id: store.selectedControlId,
          compliance_value: this.selected,
          comment: this.comment
        });
      } catch (e) {
        console.error(e);
      }
    },
  },
};
</script>

<script setup>
import { store } from "../store.js";
</script>

<style scoped>
.flex-container {
  display: flex;
  margin-top: 100px;
  margin-left: 25px;
  margin-right: 25px;
  min-height: 400px;
  height: 100%;
}
.flex-child {
  flex: 50%;
}
.white-text {
  color: white;
}
.accordian-button {
  border-radius: 0% !important;
  width: 100% !important;
}
</style>
