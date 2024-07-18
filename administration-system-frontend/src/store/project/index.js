import projectGetters from './getters';
import projectMutations from './mutations';
import projectActions from './actions';
export default {
    namespaced : true,
   state:{
    //  project list variable 
    projects: {},
    errors: null,
    projectLinks :{
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1
    },
     },
     getters :projectGetters ,
     mutations : projectMutations ,
     actions : projectActions
}