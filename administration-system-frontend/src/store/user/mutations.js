export default {
  setUsers(state, payload) {
    state.users = payload;    
  },
  setPermissions(state, permissions) {
    state.userPermissions = new Set();
    permissions.forEach(permission => {
        state.userPermissions.add(permission.name)
    });
    
    
  },
  setUserProjects(state, payload) {
    state.userProjects = payload;    
    console.log(state.userProjects)
  }
  
 

}