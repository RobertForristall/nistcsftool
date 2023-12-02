/**
 * Store file for maintaining a reactive state across the application that forces
 * a re-render whenever a property is changed
 */

// Import the reactive fucntion from vue to create a reactive variable
import { reactive } from "vue";

/**
 * Export the app wide reactive state used in this application
 * @property pageFlag: number => Dectates the page/component loaded in the single page app
 * @property currentAppId: number => Currently selected app's database id
 * @property userApps: Array<App> => Array of apps associated to the logged in user
 */
export const store = reactive({
  pageFlag: 0,
  currentAppId: -1,
  userApps: [],
  phaseFlag: 0,
  selectedControlId: "",
  controlComplianceValues: [],
  selectedRequirementId: ""
});
