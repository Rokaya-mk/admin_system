<template>
    <div class="px-3">
        <FlashMessage ref="flashMessage"></FlashMessage>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between bg-dark">
                        <h5 class="text-light">Users List</h5>
                        <button class="btn btn-success"
                                 v-if="userPermissions.has('users-create')"
                                @click="openModal" >
                                    add New User
                        </button>
                    </div>
                    <div class="card-body" >
                        <div class="row px-5 d-flex justify-content-between align-items-center mb-2">
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search_type">Search Type</label>
                                    <select  class="form-control" v-model="searchData.search_type">
                                        <option value="name">Name</option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search_value">Search Value</label>
                                    <input type="text" class="form-control" 
                                            v-model="searchData.search_value" 
                                            @keyup="search">
                                </div>
                            </div> -->
                            <!-- <div class="col-md-3  mt-1">
                                <button @click="search" class="btn btn-success">
                                    <i class="fa fa-search"></i>
                                </button>
                                
                            </div> -->
                        </div>
                        <div class="table-responsive" v-if="userPermissions.has('users-read')">
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in users" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.role.name }}</td>
                                        <td>
                                            <button class="btn btn-success mx-1"
                                                     v-if="userPermissions.has('users-update')"
                                                    @click="editUser(user)">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger mx-1"
                                                 v-if="userPermissions.has('users-delete')"
                                                    @click="deleteUser(user)">
                                                    <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                {{ !editMode ? "Create user" : "Update user" }}
                                </h5>
                                <button @click="closeModal" type="button" class="btn-close" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="name">Name</label>
                                    <input @blur="validateName" type="text" class="form-control" v-model="userData.name" />
                                    <span v-if="userErrors.name" class="text-danger">{{ userErrors.name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                         <label for="email">Email</label>
                                         <input @blur="validateEmail" type="email" class="form-control" v-model="userData.email" :disabled=" editMode ? '' : disabled" />
                                         <span v-if="userErrors.email" class="text-danger">{{ userErrors.email }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12" v-if="!editMode">
                                    <div class="form-group my-1">
                                        <label for="password">Password</label>
                                        <input type="password" 
                                        v-model="userData.password"
                                        class="form-control"
                                        placeholder="Password" >
                                        <span v-if="userErrors.password" class="text-danger">{{ userErrors.password }}</span>
                                    </div>
                                </div>
                                <div v-if="!editMode" class="col-md-12">
                                    <div class="form-group my-1">
                                        <label for="password">Password Confirmation</label>
                                        <input type="password" 
                                        v-model="userData.password_confirmation"
                                        class="form-control"
                                        placeholder="Password" >
                                        <span v-if="userErrors.password_confirmation" class="text-danger">{{ userErrors.password_confirmation }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="search_type">Role</label>
                                        <select class="form-control" v-model="userData.role_id">
                                            <option value="1" >Admin</option>
                                            <option value="2">User</option>
                                        </select>
                                        <span v-if="userErrors.role_id" class="text-danger">{{ userErrors.role_id }}</span>
                                    </div>
                                </div>
                                
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button @click="closeModal" type="button" class="btn btn-secondary">Close</button>
                                <button @click="!editMode ? saveUser() : updateUser()" type="button" class="btn" :class="{'btn-success': !editMode, 'btn-warning': editMode}">
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
 import { Modal } from "bootstrap";
 import { mapGetters, mapActions } from "vuex";
 import FlashMessage from "@/components/FlashMessage.vue";
 export default {
     components:{
         FlashMessage
     },
     data() {
         return {
             editMode: false,
             modal: "",
             userData: {
                 id: "",
                 name: "", 
                 email : "",
                 password : "",
                 password_confirmation:"",
                 role_id : ""
             },
             // object error
             userErrors: {},
             // searchData: {
             //         search_type: "name",
             //         search_value: "",
             //     },
         };
     },
     mounted() {
 
         this.modal = new Modal(document.getElementById("exampleModal"));
         this.getUsers();  
              
         
     },
     computed: {
         /* access to getter with mapgetter 
         users : to get users list
         userPermissions : get the permissions of this user
         */
         ...mapGetters({
             users :'user/users',
              userPermissions : 'user/userPermissions',
         }),
         
     },
     methods: {
         ...mapActions({
             setFlashMessage : 'flash/setFlashMessage',
             getUsers : 'user/getUsers',
             // searchuser : 'user/searchuser'
         }),
         // search() {
         //          this.searchuser(this.searchData)
         //     },
         openModal() {
             this.editMode = false;
             this.userData.name = "";
             this.userData.email = "";
             this.userData.password = "";
             this.userData.password_confirmation = "";
             this.userData.role_id = "";
             this.modal.show();
         },
 
         closeModal() {
             this.modal.hide();
         },
         // save user method
         saveUser() {
             if (this.validateData()) {
                 this.$store
                     .dispatch("user/storeUser", this.userData)
                     .then((response) => {
                         this.getUsers();
                         this.closeModal();
                         this.setFlashMessage({ message: 'user was created !!', type: 'alert-success' });
                     })
             }
         },
         // show edit user modal
         editUser(user) {
            console.log(user)
             this.editMode = true;
             this.userData.id = user.id;
             this.userData.name = user.name;
             this.userData.email = user.email;
             this.userData.password = user.password;
             this.userData.password_confirmation = user.password_confirmation;
             this.userData.role_id = user.role.id;
             this.modal.show();
         },
         updateUser(){
             if (this.validateData()) {
                 this.$store
                     .dispatch("user/updateUser", this.userData)
                     .then((response) => {
                         this.getUsers();
                         this.closeModal();
                         this.setFlashMessage({ message: 'User was Updated !!', type: 'alert-success' });
                     });
             }
         },
         deleteUser(user){
             if (confirm("Are you sure you want to delete user!")) {
                 this.$store
                     .dispatch("user/deleteUser", user)
                     .then((response) => {
                         this.getUsers();
                         this.closeModal();
                         this.setFlashMessage({ message: 'User was Deleted !!', type: 'alert-success' });
                     });
             }
         },
        
         // validate Name
         validateName() {
             if (!this.userData.name) {
                 this.userErrors.name = "Name is required";
             } else {
                 delete this.userErrors.name;
             }
         },
         // validate email 
         validateEmail() {
             if (!this.userData.email) {
                 this.userErrors.email = "Email is required";
             } else {
                 delete this.userErrors.email;
             }
         },
         // validate password 
         validatePassword() {
             if (!this.userData.password) {
                 this.userErrors.password = "Password is required";
             } else {
                 delete this.userErrors.password;
             }
         },
          // validate role 
          validateRole() {
             if (!this.userData.role_id) {
                 this.userErrors.role_id = "Role is required";
             } else {
                 delete this.userErrors.role_id;
             }
         },
        
         // // validate data methode
         validateData() {
             this.validateName();
            this.validateEmail();
            this.validatePassword();
            this.validateRole();
             return Object.keys(this.userErrors).length === 0;
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
 