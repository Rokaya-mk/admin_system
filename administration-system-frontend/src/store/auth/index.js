import authGetters from './getters';
import authMutations from './mutations';
import authActions from './actions';
export default {
    namespaced : true,
   state:{
      user: null,
      token: null,
      authError: ''
     },
     getters :authGetters ,
     mutations : authMutations ,
     actions : authActions
}