<template lang="">
    <main class="content px-3 py-4" v-if="projects">
       <div class="row">
        <div class="col-md-6">
            <ProjectBarChart/>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between bg-dark">
                            <h5 class="text-light">Projects List</h5>
                        </div>
                        <div class="card-body" >
                            <div class="row px-5 d-flex justify-content-between align-items-center mb-2">
                            </div>
                            <div class="table-responsive" >
                                <table class="table table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Assigned To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(project, index) in projects" :key="index">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ project.name }}</td>
                                            <td>{{ project.description }}</td>
                                            <td :class="getStatusClass(project.status)">{{ project.status }}</td>
                                            <td>{{ project.user.name }}</td>
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
    </main>
</template>
<script>
import ProjectBarChart from '../components/ProjectBarChart.vue'
import ProjectsList from '@/components/ProjectsList'
import { mapGetters, mapActions } from "vuex";
import axios from 'axios';

export default {
    components:{
        ProjectBarChart,
    },
     data() {
         return {
            projects:{},
             projectData: {
                 id: "",
                 name: "", 
                 description : "",
                 status : "",
                 user_id : ""
             },
         };
     },
     mounted() {
        
         this.getProjects();
         this.getUsers();
         
         // this.$store.dispatch('user/getUserRolesPermissions');
         
     },
     computed: {
         /* access to getter with mapgetter 
         projects : to get projects list
         errors :  get api errors
         */
         ...mapGetters({
             users : 'user/users',
             // userRoles : 'user/userRoles',
         }),
         
     },
     methods: {
         ...mapActions({
             getUsers : 'user/getUsers',
             // searchproject : 'project/searchproject'
         }),
         getProjects(){
            axios.get(`projects`).then((response)=>{
                this.projects = response.data.data
                this.projects = this.projects.slice(0,5)
            })
         },
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
<style lang="">
    
</style>