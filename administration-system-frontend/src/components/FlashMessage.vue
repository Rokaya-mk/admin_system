<template lang="">
    <div v-if="message"
         :class="['alert', messageType]">
      {{ message }}
    </div>
  </template>
  
  <script>
  import { mapState } from 'vuex';
  export default {
    computed: {
    ...mapState({
      message: state => state.flash.message,
      messageType: state => state.flash.type
    })
  }
   
    
  }
  </script>
  <style lang="">
      
  </style>