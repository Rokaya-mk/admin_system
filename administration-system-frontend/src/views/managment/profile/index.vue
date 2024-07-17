<template  lang="" >
    <div class="container mt-4">

        <FlashMessage ref="flashMessage"></FlashMessage>
        <div class="row" v-if="profile && user">
            <div class="col-md-4 mt-2">
                <div class="card text-center">
                    <div class="card-header ">
                      Profile
                    </div>
                    <div class="card-body text-center">
                      <h5 class="card-title">Name: {{ user.name }} </h5>
                      <h5 class="card-text">Email:  {{ user.email}} </h5>
                      <p class="card-text">Role:  {{ user.role.name}} </p>
                    </div>
                  </div>
            </div>
            <div class="col-md-8" >
                <div v-if="profileError" >
                    <div  v-for="(error, index) in profileError" :key="index">
                        <div class="alert alert-danger">{{ error }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mt-2">
                        <div class="card-header bg-dark">
                            <h5 class="text-light text-center">Update Password of {{ profile.name }} </h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="update()" >
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="old_password">Old Password</label>
                                            <input type="password" class="form-control" v-model="profileData.old_password" />
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" class="form-control" v-model="profileData.password"  />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm New Password</label>
                                            <input type="password" class="form-control" v-model="profileData.password_confirmation"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>
<script>
import FlashMessage from "@/components/FlashMessage.vue";
import { mapActions, mapGetters } from "vuex";
export default {
    components:{
        FlashMessage
    },
    data(){
        return{
           profileData:{
            id:'',
            old_password : '',
            password : '',
            password_confirmation : '',
           },
        }
    },
    computed: {
        ...mapGetters({
            'profile' : 'profile/profile',
            'user' : 'auth/user',
            'profileError' : 'profile/profileError'
        })
    },
    mounted() {
        this.getProfile();
        console.log("s")
        console.log(this.user)
        
    },
    methods: {
        ...mapActions({
            'getProfile' : 'profile/getProfile',
            'updatePassword': 'profile/updatePassword',
            'setFlashMessage' : 'flash/setFlashMessage',
             'singnout' : 'auth/logout'
        }),
        update(){
            
            this.profileData.id = this.profile.id
            this.updatePassword(this.profileData).then(() => {
                if(!this.profileError){
                    this.setFlashMessage({ message: 'Password Updeted Successfully!!', type: 'alert-success' });
                    this.singnout()
                    
                    setTimeout(() => {
                        window.location = "/"
                        }, 2000);
                    
            }
            })
        },
        
    },

}
</script>
<style lang="">
    
</style>