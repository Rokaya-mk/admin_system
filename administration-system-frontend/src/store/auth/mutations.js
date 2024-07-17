export default{
    setToken(state, token) {
        state.token = token
    },
    setUser(state, user) {
        state.user = user
        console.log(state.user)
        
    },
    setError(state, authError) {
        state.authError = authError

    }
    
}