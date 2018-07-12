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
      },
      base_url: 'http://localhost:8888/sisylana/events/administrator'
    }
  },
  mounted(){
    axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*'
    axios.get(this.base_url + '/index.php?option=com_spevents&task=events.getData')
    .then(response=>{
      console.log(response)
    })
  }
}
</script>

<style>

</style>
