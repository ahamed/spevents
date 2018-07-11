<template>
  <div id="app">
      <full-calendar :events="events" :config="config" />  
  </div>
</template>

<script>

import { FullCalendar } from 'vue-full-calendar'
import axios from 'axios'

export default {
  name: 'App',
  components: {
    FullCalendar
  },
  data(){
    return {
      events: [
        {
          title  : 'event1',
          start  : '2018-07-11',
        },
        {
          title  : 'event2',
          start  : '2010-01-05',
          end    : '2010-01-07',
        },
        {
          title  : 'event3',
          start  : '2010-01-09T12:30:00',
          allDay : false,
        }
      ],
      config: {
        defaultView: 'month',
        editable: false
      }
    }
  },
  mounted(){
    
  }
}
</script>

<style>

</style>
