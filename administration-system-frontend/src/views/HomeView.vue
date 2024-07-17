<template>
  <div class="home">
   <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="row" v-if="authenticated">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header d-flex justify-content-between bg-dark">
                      <h5 class="text-light">Projects List</h5>
                  </div>
                  <div class="card-body" >
                      <div class="row px-5 d-flex justify-content-between align-items-center mb-2">
                      </div>
                      <div class="table-responsive">
                          <table class="table table-hover text-center">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Description</th>
                                      <th>Status</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr v-for="(project, index) in userProjects" :key="index">
                                      <td>{{ index + 1 }}</td>
                                      <td>{{ project.name }}</td>
                                      <td>{{ project.description }}</td>
                                      <td :class="getStatusClass(project.status)">{{ project.status }}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
                  
              </div>
          </div>
      </div>
  </div>
   </div>
  </div>
</template>

<script>
// @ is an alias to /src
import ProjectsList from '@/components/ProjectsList'
import { mapGetters, mapActions } from "vuex";
import axios from 'axios';

export default {
    components:{
    },
     data() {
         return {
             
         };
     },
     mounted() {
        if(this.authenticated){
            this.getUserProjects(this.user);
        }else{
            this.$router.push({ path: "/login" })
        }
         
         // this.$store.dispatch('user/getUserRolesPermissions');
         
     },
     computed: {
         /* access to getter with mapgetter 
         projects : to get projects list
         errors :  get api errors
         */
         ...mapGetters({
             users : 'user/users',
            'authenticated' : 'auth/authenticated', 
             user : 'auth/user',
             userProjects : 'user/userProjects',
         }),
         
     },
     methods: {
         ...mapActions({
             getUserProjects : 'user/getUserProjects'
         }),
         // change status color
         getStatusClass(status) {
         switch (status) {
             case 'in_progess':
             return 'text-primary';
             case 'finished':
             return 'text-success';
             case 'canceled':
             return 'text-danger';
             default:
             return '';
             }
         },
     },
}
</script>
