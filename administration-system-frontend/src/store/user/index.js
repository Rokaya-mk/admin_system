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
      userLinks :{
          total: 0,
          per_page: 2,
          from: 1,
          to: 0,
          current_page: 1
      },
   
     },
     getters : userGetters,
     mutations : userMutations,
     actions :userActions
}