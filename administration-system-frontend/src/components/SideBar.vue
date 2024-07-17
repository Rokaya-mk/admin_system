<template lang="">
  <aside v-if="authenticated" id="sidebar" :class="{ expand: isExpanded }">
      <div class="d-flex">
          <button  @click="toggleSidebar" id="sidebarbutton" class="toggle-btn" type="button">
              <i class="lni lni-grid-alt"></i>
          </button>
          <div class="sidebar-logo">
              <a href="#">Projects Management</a>
          </div>
      </div>
      <ul class="sidebar-nav">
       
          <li class="sidebar-item" v-if="user.role_id == 1">
              <router-link :to="{name: 'dashboard'} ">
                  <i class="lni lni-agenda"></i>
                  <span>Dashboard</span>
              </router-link>
          </li>
          <li class="sidebar-item" v-if="user.role_id == 2">
              <router-link :to="{name: 'home'} ">
                  <i class="lni lni-agenda"></i>
                  <span>Home</span>
              </router-link>
          </li>
        <li class="sidebar-item" v-if="userPermissions.has('projects-read') && user.role_id == 1">
            <router-link :to="{name: 'Project'} ">
                <i class="lni lni-agenda"></i>
                <span>Projects</span>
            </router-link>
        </li>
        <li class="sidebar-item" v-if="userPermissions.has('users-read') && user.role_id == 1">
            <router-link :to="{name: 'Users'} ">
                <i class="lni lni-agenda"></i>
                <span>Users</span>
            </router-link>
        </li>
        <li class="sidebar-item" >
            <router-link :to="{name: 'profile'} ">
                <i class="lni lni-agenda"></i>
                <span>Profile</span>
            </router-link>
        </li>
       
         
      </ul>
      <div class="sidebar-footer">
          <a href="#" class="sidebar-link">
              <i class="lni lni-exit"></i>
              <span>Logout</span>
          </a>
      </div>
  </aside>
</template>
<script>
 import { mapGetters, mapActions } from "vuex";

  export default {
  data() {
    return {
      isExpanded: false
    };
  },
  computed:{
    ...mapGetters({
            'authenticated' : 'auth/authenticated', 
              userPermissions : 'user/userPermissions',
              user : 'auth/user'
         }),
  },
  methods: {
    toggleSidebar() {
      console.log(this.user.id)
      this.isExpanded = !this.isExpanded;
    }
  }
};
</script>
<style>
  
  
</style>