export default {
  setUsers(state, payload) { 
    console.log(payload.meta)
    state.users = payload.data
        state.userLinks = {
            total: payload.meta.total,
            per_page: payload.meta.per_page,
            from: payload.meta.from,
            to: payload.meta.to,
            current_page: payload.meta.current_page,
            last_page: payload.meta.last_page,
            
        } 
  },
  setPermissions(state, permissions) {
    state.userPermissions = new Set();
    permissions.forEach(permission => {
        state.userPermissions.add(permission.name)
    });
    
    
  },
  setUserProjects(state, payload) {
    console.log(payload)
    state.userProjects =payload.data.data
    state.userLinks = {
        total: payload.data.total,
        per_page: payload.data.per_page,
        from: payload.data.from,
        to: payload.data.to,
        current_page: payload.data.current_page,
        last_page: payload.data.last_page,
        
    }  
    console.log(state.userLinks)
  }
  
 

}