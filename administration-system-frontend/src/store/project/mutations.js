export default{
    setProject(state, payload) {
        state.projects = payload
    },
    setErrors(state, error) {
        state.error = error;
    },
    set_projects: (state, data) => {
        state.projects = data.data
        state.projectLinks = [];
        state.projectLinks.push(data.links['first']);
        state.projectLinks.push(data.links['next']);
        state.projectLinks.push(data.links['last']);
       
        console.log(state.projectLinks)
                
        
    },
    
}