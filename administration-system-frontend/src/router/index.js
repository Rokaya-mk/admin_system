import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '@/views/Dashboard.vue'
import Home from '@/views/HomeView.vue'
import Singin from '@/views/auth/Login.vue';
import Register from '@/views/auth/Register.vue';
import Project from '@/views/managment/projects'
import Users from '@/views/managment/users'
import Profile from '@/views/managment/profile'
import store from '@/store'


const routes = [
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    beforeEnter: (to, from, next) => {
      if(!store.getters['auth/authenticated']){
        return next({name : 'Singin' })
      }
      next();
    }
  },
  {
    path: '/',
    name: 'home',
    component: Home, 
    beforeEnter: (to, from, next) => {
      if(!store.getters['auth/authenticated']){
        return next({name : 'Singin' })
      }
      next();
    }

  },
  {
    path: '/login',
    name: 'Singin',
    component: Singin,
    
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    
  },
  {
    path: '/projects',
    name: 'Project',
    component: Project,
    
  },
  {
    path: '/users',
    name: 'Users',
    component: Users,
    
  },
  {
    path: '/profile',
    name: 'profile',
    component: Profile,
    
  }
  // {
  //   path: '/notifications',
  //   name: 'Notifications',
  //   component: Notifications,
    
  // },
]


const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})


export default router
