import userGetters from './getters';
import userMutations from './mutations';
import userActions from './actions';
export default {
     namespaced : true,
   state:{
      //  user list variable 
      users : {},
      userPermissions : new Set(),
      errors: null,
      userProjects : {},
   
     },
     getters : userGetters,
     mutations : userMutations,
     actions :userActions
}