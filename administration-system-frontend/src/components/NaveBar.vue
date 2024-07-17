<template lang="">
  <nav v-if="authenticated" class="navbar navbar-expand px-4 py-3">
    <form action="#" class="d-none d-sm-inline-block">
    </form>
    <li>
      <Notifications/>
    </li>
    <div class="navbar-collapse collapse">
      <ul class="navbar-nav ms-auto">
        
        <li class="nav-item dropdown">
          <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
             
          </a>
          <div class="dropdown-menu dropdown-menu-end rounded"></div>
        </li>
        <li class="nav-item " v-if="authenticated">
          <router-link class="nav-link" :to="{name: 'profile'} ">Profile</router-link>
        </li>
        <li class="nav-item" v-if="authenticated">
              <a class="nav-link" style="cursor: pointer;" @click="logout()">Logout</a>
        </li>
        
      </ul>
    </div>
  </nav>
</template>
<script>
import Notifications from './Notifications';
import {mapGetters,mapActions} from 'vuex';
export default {
    computed : {
        ...mapGetters({
            'authenticated' : 'auth/authenticated', 
            'user' : 'auth/user',

        })
    },
    mounted() {
      // console.log(this.user.role_id)
      // console.log(this.user,this.authenticated)
    },
  components:{
    Notifications,
  },
  methods: {
    ...mapActions({
            'singnout' : 'auth/logout'
        }),
    logout(){
            this.singnout().then(() => {
              // this.$router.push({ path: "/login" })
              setTimeout(() => {
                  this.$router.push({ path: "/login" })
                        }, 1000);
                    
            })
        }
  },
};
</script>
<style lang=""></style>
