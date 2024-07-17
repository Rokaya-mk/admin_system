import axios from "axios";

export default{
    // get users list
  getUsers({commit,state}) {
    axios
        .get("users")
        .then((response) => {
            commit('setUsers', response.data.data)
        })
        .catch((error) => {
            console.error("Error fetching users:", error);
        });
    },
    
    getUserProjects({commit,state},user) {
        axios
            .get(`userProjects/${user.id}`)
            .then((response) => {
                console.log(response.data)
                commit('setUserProjects', response.data)
            })
            .catch((error) => {
                console.error("Error fetching user projects:", error);
            });
        },
     // store users in db
     storeUser({commit}, payload) {
        axios
            .post("users", payload)
            .then((response) => {
                console.log(response.data);
            }).catch((error) => {
                console.error("Error storing users:", error);
            });
    },
     // update a users
     updateUser({commit}, payload) {
        axios.put(`users/${payload.id}`, payload)
            .then((response) => {
                console.log(
                    "users updated successfully:",
                    response.data
                );
            })
            .catch((error) => {
                console.error("Error updating users:", error);

        });
    },
     // delete users from db
    deleteUser({commit}, payload) {
        axios
            .delete("users/" + payload.id)
            .then((response) => {
                console.log(
                    "users deleted successfully:",
                    response.data
                );
            })
            .catch((error) => {
                console.error("Error deleting users:", error);
            });

    }
  
}