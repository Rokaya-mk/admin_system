<template lang="">
  
  <div class="wrapper">
    <!-- Start SideBar -->
    <Sidebar/>
    <!-- End SideBar -->
    <div class="main">
      <!-- Start NavBar -->
      <Navebar/>
      <!-- End NavBar -->
      <router-view ></router-view>
      <!-- Start Footer -->
      <!-- <Footer/> -->
      <!-- End Footer -->
    </div>
  </div>
</template>
<script>
  import Sidebar from './components/SideBar.vue';
  import Navebar from './components/NaveBar.vue';
  import Footer from './components/Footer.vue';
  import { mapGetters } from 'vuex'

  export default{
    beforeRouteUpdate(to, from, next) {
    if (to.path === from.path) {
      this.resetComponent();
    }
    next();
  },
  methods: {
    resetComponent() {
      // Your logic to reset the component
    }
  },
  components:{
      Sidebar,
      Navebar,
      Footer,
    }
   
   
  }
  
</script>
<style>
  
</style>