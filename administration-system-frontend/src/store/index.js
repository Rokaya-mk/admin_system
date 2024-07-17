import { createStore } from 'vuex'
import auth from './auth';
import projectModule from './project'
import flash from './flash'
import profile from './profile'
import userModule from './user'
import notificationsModule from './notification';

export default createStore({
  state: {
  },
  getters: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    auth: auth,
    flash: flash,
    project : projectModule,
    user : userModule,
    notification :notificationsModule,
    profile :profile
  }
})
