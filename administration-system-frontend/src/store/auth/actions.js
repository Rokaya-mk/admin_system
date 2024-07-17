import axios from 'axios';
export default {
    async singIn({ commit,dispatch }, payload) {
        commit('setError', '');
        try {
            const response = await axios.post('login', payload);
            dispatch('attempt', response.data.data.token)
        } catch (error) {
            console.log(error)
            if (error.response && error.response.status === 401) {
                commit('setError', 'Invalid username or password');
              } else {
                commit('setError', 'An error occurred. Please try again.');
              }
        }
    },
    async register({ commit,dispatch }, payload) {
        commit('setError', '');
        axios
            .post("register", payload)
            .then((response) => {
                // dispatch('attempt', response.data.data.token)
                window.location = "/login"
            }).catch((error) => {
                if (error.response.status === 422) { // Validation error
                    commit('setErrors', error.response.data.errors);
                } else {
                    console.error("Error registration:", error);
                }
            });
    },

    async attempt({ commit, state }, token) {
        try {
            if (token) {
                commit('setToken', token);
            }
            if (!state.token) { return; }
            const response = await axios.get('user-profile');
            console.log('success')
            commit('setUser', response.data.user);
            commit('user/setPermissions', response.data.userPermissions,{ root: true });
        } catch (error) {
            console.log(error, 'fail2')
            commit('setToken', null);
            commit('setUser', null);
        }
    },
    // logout user 
    logout({commit}){
        axios.post("logout")
        .then((response) => {
            console.log(response)
            commit('setToken', null);
            commit('setUser', null);
            localStorage.removeItem('token');
            console.log(
                "user logout successfully:",
                response
            );
        })
        .catch((error) => {
            console.error("Error loging user:", error);
        });
    }








    
}