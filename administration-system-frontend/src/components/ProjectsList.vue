<template>
    <div class="px-3">
        <FlashMessage ref="flashMessage"></FlashMessage>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between bg-dark">
                        <h5 class="text-light">Last Project added</h5>
                        <button class="btn btn-success"
                                 v-if="userPermissions.has('projects-create')"
                                @click="openModal" >
                                New Project
                        </button>
                    </div>
                    <div class="card-body" >
                        <div class="row px-5 d-flex justify-content-start  mb-2">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search_value">Search Value</label>
                                <input type="text" class="form-control" 
                                        v-model="search_value" 
                                        @keyup="search">
                            </div>
                        </div>
                        <div class="col-md-3  mt-3">
                            <button @click="search" class="btn btn-success">
                                <i class="fa fa-search"></i>
                            </button>
                            
                        </div>
                        </div>
                        
                        <div class="table-responsive" v-if="userPermissions.has('projects-read')">
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Assigned To</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(project, index) in projects" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ project.name }}</td>
                                        <td>{{ project.description }}</td>
                                        <td :class="getStatusClass(project.status)">{{ project.status }}</td>
                                        <td>{{ project.user.name }}</td>
                                        <td>
                                            <button class="btn btn-success mx-1"
                                                     v-if="userPermissions.has('projects-update')"
                                                    @click="editProject(project)">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger mx-1"
                                                 v-if="userPermissions.has('projects-delete')"
                                                    @click="deleteProject(project)">
                                                    <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination -->
                        <Bootstrap5Pagination 
                            :data="projects" 
                            @pagination-change-page="getProjects"
                        />
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                {{ !editMode ? "Create project" : "Update project" }}
                                </h5>
                                <button @click="closeModal" type="button" class="btn-close" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="name">Name</label>
                                    <input @blur="validateName" type="text" class="form-control" v-model="projectData.name" />
                                    <span v-if="projectErrors.name" class="text-danger">{{ projectErrors.name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                         <label for="description">Description</label>
                                         <textarea @blur="validateDescription" class="form-control"  v-model="projectData.description"></textarea>
                                         <span v-if="projectErrors.description" class="text-danger">{{ projectErrors.description }}</span>
                                    </div>
                                </div>
                                <div v-if="editMode" class="col-md-12">
                                 <div class="form-group">
                                      <label for="search_type">Status</label>
                                    <select class="form-control" v-model="projectData.status">
                                        <option value="new">New</option>
                                        <option value="in_progess" class="text-primary">In Progress</option>
                                        <option value="finished" class="text-success">Finished</option>
                                        <option value="canceled" class="text-danger">Canceled</option>
                                    </select>
                                 </div>
                             </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="search_type">Assign To</label>
                                    <select class="form-control" v-model="projectData.user_id">
                                        <option v-for="(user, index) in users" :key="index" :value="user.id">{{ user.name }}</option>
                                    </select>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click="closeModal" type="button" class="btn btn-secondary">Close</button>
                                <button @click="!editMode ? saveProject() : updateProject()" type="button" class="btn" :class="{'btn-success': !editMode, 'btn-warning': editMode}">
                                {{ !editMode ? "Save changes" : "Update " }}
                                </button>
                            </div>
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
 import { Bootstrap5Pagination } from 'laravel-vue-pagination';
 import { Modal } from "bootstrap";
 import { mapGetters, mapActions } from "vuex";
 import FlashMessage from "@/components/FlashMessage.vue";
 export default {
     components:{
         FlashMessage,
         Bootstrap5Pagination

        },
     data() {
         return {
             editMode: false,
             modal: "",
             projectData: {
                 id: "",
                 name: "", 
                 description : "",
                 status : "",
                 user_id : ""
             },
             // object error
             projectErrors: {},
             search_value : ""
         };
     },
     mounted() {
 
         this.modal = new Modal(document.getElementById("exampleModal"));
         this.getProjects();
         this.getUsers()
        
         // this.$store.dispatch('user/getUserRolesPermissions');
         
     },
     computed: {
         /* access to getter with mapgetter 
         projects : to get projects list
         userRoles : verify roles of this authenticated user 
         userPermissions : get the permissions of this user
         errors :  get api errors
         */
         ...mapGetters({
             projects :'project/projects',
             projectLinks :'project/projectLinks',
             users : 'user/users',
             // userRoles : 'user/userRoles',
              userPermissions : 'user/userPermissions',
             errors :"project/errors"
         }),
         
     },
     methods: {
         ...mapActions({
             setFlashMessage : 'flash/setFlashMessage',
             getProjects : 'project/getProjects',
             getUsers : 'user/getUsers',
             searchP : 'project/searchProject'
         }),
         search() {
            this.searchP(this.search_value)
             },
        getResults(link) {
            if(!link.url || link.active) {
                return;
            }else{
                this.$store.dispatch('project/getProjectsResults', link);
            }
        },
         openModal() {
             this.editMode = false;
             this.projectData.name = "";
             this.projectData.description = "";
             this.projectData.user_id = "";
             this.modal.show();
         },
 
         closeModal() {
             this.modal.hide();
         },
         // save project method
         saveProject() {
             if (this.validateData()) {
                 this.projectData.status = "new";
                 this.$store
                     .dispatch("project/storeProject", this.projectData)
                     .then((response) => {
                         this.getProjects();
                         this.closeModal();
                         this.setFlashMessage({ message: 'project was created !!', type: 'alert-success' });
                     })
             }
         },
         // show edit project modal
         editProject(project) {
             this.editMode = true;
             this.projectData.id = project.id;
             this.projectData.name = project.name;
             this.projectData.description = project.description;
             this.projectData.status = project.status;
             this.projectData.user_id = project.user.id;
             this.modal.show();
         },
         updateProject(){
             if (this.validateData()) {
                 this.$store
                     .dispatch("project/updateProject", this.projectData)
                     .then((response) => {
                        console.log(response)
                         this.getProjects();
                         this.closeModal();
                         this.setFlashMessage({ message: 'Project was Updated !!', type: 'alert-success' });
                     });
             }
         },
         deleteProject(project){
             if (confirm("Are you sure you want to delete project!")) {
                 this.$store
                     .dispatch("project/deleteProject", project)
                     .then((response) => {
                         this.getProjects();
                         this.closeModal();
                         this.setFlashMessage({ message: 'Project was Deleted !!', type: 'alert-success' });
                     });
             }
         },
        
         // validate Name
         validateName() {
             if (!this.projectData.name) {
                 this.projectErrors.name = "Name is required";
             } else {
                 delete this.projectErrors.name;
             }
         },
         // validate description 
         validateDescription() {
             if (!this.projectData.description) {
                 this.projectErrors.description = "Description is required";
             } else {
                 delete this.projectErrors.description;
             }
         },
         // validate user 
         validateUser() {
             if (!this.projectData.user_id) {
                 this.projectErrors.user_id = "assigned user is required";
             } else {
                 delete this.projectErrors.user_id;
             }
         },
        
         // // validate data methode
         validateData() {
             this.validateName();
             this.validateDescription();
             this.validateUser();
             return Object.keys(this.projectErrors).length === 0;
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
 <style></style>
 