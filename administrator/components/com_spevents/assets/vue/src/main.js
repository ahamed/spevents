// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import VueFullCalendar from 'vue-full-calendar'

import 'fullcalendar/dist/fullcalendar.min.css'

Vue.config.productionTip = false

Vue.use(VueFullCalendar)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  components: { App },
  template: '<App/>'
})
