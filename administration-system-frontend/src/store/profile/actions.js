import axios from 'axios';
export default {
    getProfile({commit,state}){
        state.profileErrors = [];
        axios.get("profile")
             .then((response) => {
                 commit('setProfile',response.data)
             })
             .catch((error) => {
                 commit('setError',error.response.data)
             })
    },
    async updatePassword({commit,state},payload){
        state.profileErrors = [];
        await axios.post(`profile/passwordUpdate/${payload.id}`,payload)
        .then((response) => {
            console.log(
                "password updated successfully:",
                response.data
            );
        })
        .catch((error) => {
            if (error.response.status === 422  ) { // Validation error
                const errorMessages = Object.values(error.response.data.errors).flat();
                commit('setError', errorMessages);
            } else {
                commit('setError', error.response.data);
                console.error("Error updating password:",  error.response.data.message);
            }
        });
    }
    







    
}