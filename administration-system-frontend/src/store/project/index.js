import projectGetters from './getters';
import projectMutations from './mutations';
import projectActions from './actions';
export default {
    namespaced : true,
   state:{
    //  project list variable 
    projects: {},
    errors: null,
    projectLinks :{}
     },
     getters :projectGetters ,
     mutations : projectMutations ,
     actions : projectActions
}