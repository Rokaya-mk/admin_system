<template lang="">
    <div class="container">
        <div class="row">
           
            <div class="col-md-6 mx-auto ">
                <div class="row mt-5 pt-5">
                    <div class="col-md-12">
                        <h3>Register  </h3>
                        <!-- Show errors Register -->
                        <div v-if="registerError" class="alert alert-danger">{{ registerError }}</div>
                        <div class="card">
                            <div class="card-header bg-secondary">
                                <h5 class="text-center text-light">Login</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="sabmit()">
                                    <div class="form-group my-1">
                                        <label for="name">Name</label>
                                        <!-- Classe CSS "is-invalid" si erreur pour "name" -->
                                        <input type="name" 
                                            v-model="user.name" 
                                            class="form-control"
                                            placeholder="Name">
                                        <!-- Le message d'erreur -->
                                        <span v-if="errors.name" class="text-danger">{{ errors.name }}</span>
                                    </div>
                                    <div class="form-group my-1">
                                        <label for="email">Email</label>
                                        <!-- Classe CSS "is-invalid" si erreur pour "email" -->
                                        <input type="email" 
                                            v-model="user.email" 
                                            class="form-control"
                                            placeholder="Email Address">
                                        <!-- Le message d'erreur -->
                                        <span v-if="errors.email" class="text-danger">{{ errors.email }}</span>
                                    </div>
                                    <div class="form-group my-1">
                                        <label for="password">Password</label>
                                        <input type="password" 
                                        v-model="user.password"
                                        class="form-control"
                                        placeholder="Password" 
                                        autocomplete="new-password">
                                    <!-- Le message d'erreur -->
                                    <span v-if="errors.password" class="text-danger">{{ errors.password }}</span>
                                    </div>
                                    <div class="form-group my-1">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" 
                                        v-model="user.password_confirmation"
                                        class="form-control"
                                        placeholder="Password Confirmation" 
                                        autocomplete="new-password_confirmation">
                                    <!-- Le message d'erreur -->
                                    <span v-if="errors.password_confirmation" class="text-danger">{{ errors.password_confirmation }}</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group my-1">
                                                <button type="submit" class="btn btn-warning float-start">Register</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <a  class="btn btn-dark float-end my-1 text-white">Go to login</a>
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
            user : {
                name:'',
                email : '',
                password : '',
                password_confirmation : ''
            },
            errors: {},
        }
    },
    computed: {
        ...mapGetters({
            'registerError' :  'auth/authError'
        }),
    },
    methods: {
        ...mapActions({
            'register' :  'auth/register'
        }),
        validateForm() {
        this.errors = {};

        if (!this.user.name) {
            this.errors.name = 'name is required';
        }
        if (!this.user.email) {
            this.errors.email = 'email is required';
        }

        if (!this.user.password) {
            this.errors.password = 'Password is required';
        }
        if (this.user.password != this.user.password_confirmation) {
            this.errors.password_confirmation = 'Password doesn\'t much !!';
        }

        return Object.keys(this.errors).length === 0;
        },
        sabmit(){
            if (!this.validateForm()) {
                return;
            }
            this.register(this.user).then(() =>{

                //  this.$router.push({ path: "/login" })
            }
            )
            // this.singnout().then(() => this.$router.replace({name :'Singin'}))
        }
    },

}
</script>
<style lang="">
    
</style>