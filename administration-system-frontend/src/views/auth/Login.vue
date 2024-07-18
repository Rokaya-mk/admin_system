<template lang="">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto ">
                <div class="row mt-5 pt-5">
                    <div class="col-md-12">
                        <h3>Login  </h3>
                        <!-- Show errors login -->
                        <div v-if="loginError" class="alert alert-danger">{{ loginError }}</div>
                        <div class="card">
                            <div class="card-header bg-secondary">
                                <h5 class="text-center text-light">Login</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="sabmit()">
                                    <div class="form-group my-1">
                                        <label for="email">Email</label>
                                        <!-- Classe CSS "is-invalid" si erreur pour "name" -->
                                        <input type="email" 
                                            v-model="userData.email" 
                                            class="form-control"
                                            placeholder="Email Address">
                                        <!-- Le message d'erreur -->
                                        <span v-if="errors.email" class="text-danger">{{ errors.email }}</span>
                                    </div>
                                    <div class="form-group my-1">
                                        <label for="password">Password</label>
                                        <input type="password" 
                                        v-model="userData.password"
                                        class="form-control"
                                        placeholder="Password" 
                                        autocomplete="new-password">
                                    <!-- Le message d'erreur -->
                                    <span v-if="errors.password" class="text-danger">{{ errors.password }}</span>
                                    </div>
            
                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group my-1">
                                                <a class="text-primary">Forgot Password</a>
                                            </div>
                                        </div>
                                    </div> -->
            
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group my-1">
                                                <button type="submit" class="btn btn-warning float-start">Login</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <router-link  :to="{name: 'Register'} "class="btn btn-dark float-end my-1 text-white">Go to register</router-link>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import { mapActions,mapGetters } from 'vuex';
export default {
    components: {
        
    },
    data(){
        return{
            userData : {
                email : '',
                password : ''
            },
            errors: {},
        }
    },
    computed: {
        ...mapGetters({
            'loginError' :  'auth/authError',
            'authenticated' : 'auth/authenticated', 
            'user' : 'auth/user',

        }),
    },
    mounted() {
        if(this.authenticated){
                    if(this.user.role_id == 1 && this.user ){
                         this.$router.push({ path: "/dashboard" })
                    }else{
                        window.location = "/"
                    }
                }
    },
    methods: {
        ...mapActions({
            'signIn' :  'auth/singIn'
        }),
        validateForm() {
        this.errors = {};

        if (!this.userData.email) {
            this.errors.email = 'email is required';
        }

        if (!this.userData.password) {
            this.errors.password = 'Password is required';
        }

        return Object.keys(this.errors).length === 0;
        },
        sabmit(){
            if (!this.validateForm()) {
                return;
            }
            this.signIn(this.userData).then(() => {
                if(this.authenticated){
                    if( this.user && this.user.role_id == 1){
                         this.$router.push({ path: "/dashboard" })
                    }else{
                        this.$router.push({ path: "/" })
                    }
                }
            })
            // this.singnout().then(() => this.$router.replace({name :'Singin'}))
        }
    },

}
</script>
<style lang="">
    
</style>