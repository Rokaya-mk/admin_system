export default{
    setProject(state, payload) {
        state.projects = payload.data
        state.projectLinks = {
            total: payload.meta.total,
            per_page: payload.meta.per_page,
            from: payload.meta.from,
            to: payload.meta.to,
            current_page: payload.meta.current_page,
            last_page: payload.meta.last_page,
            
        } 
    },
    setErrors(state, error) {
        state.error = error;
    },
   
    
}