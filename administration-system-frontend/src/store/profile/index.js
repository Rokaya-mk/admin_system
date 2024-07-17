import authGetters from './getters';
import authMutations from './mutations';
import authActions from './actions';
export default {
    namespaced : true,
   state:{
      userProfile: null,
      profileError: null
     },
     getters :authGetters ,
     mutations : authMutations ,
     actions : authActions
}