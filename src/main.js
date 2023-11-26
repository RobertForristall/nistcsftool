/**
 * SPDX-FileCopyrightText: 2018 John Molakvoæ <skjnldsv@protonmail.com>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { generateFilePath } from '@nextcloud/router'

import Vue from 'vue'

// Component imports
import App from './App.vue'

// Bootstrap imports
import {BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// eslint-disable-next-line
__webpack_public_path__ = generateFilePath(appName, '', 'js/')

Vue.mixin({ methods: { t, n } })

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

// Create and render the new Vue project in the content element of the main.php template
export default new Vue({
  el: '#content',
  render: h => h(App),
})
