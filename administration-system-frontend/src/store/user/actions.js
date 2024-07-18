import axios from "axios";

export default{
    // get users list
  getUsers({commit},payload) {
    axios
        .get(`users?page=${payload}`)
        .then((response) => {
            commit('setUsers', response.data)
        })
        .catch((error) => {
            console.error("Error fetching users:", error);
        });
    },
     // search 
     // Search users
     searchUser({commit}, payload) {
        setTimeout(function() {
            axios.get(`searchUser?search_value=${payload}`).then((response) => {
                commit('setUsers', response.data)
            }).catch(err => {
                console.log(err);
            });
        });
    },
    getUserProjects({commit},payload) {
        axios
            .get(`userProjects/${payload[0].id}?page=${payload[1]}`)
            .then((response) => {
                commit('setUserProjects', response)
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