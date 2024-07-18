import axios from "axios";

export default {
  // retreive projects data from api 
  getProjects({commit},payload) {
    console.log(payload)
    axios
        .get(`projects?page=${payload}`)
        .then((response) => {
            console.log(response)
            commit('setProject', response.data)
            
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) { // Validation error
                commit('setErrors', error.response.data.errors);
            } else {
                console.error("Error fetching projects:", error);
            }
        });
    },
    // search 
     // Search projects
     searchProject({commit}, payload) {
        setTimeout(function() {
            axios.get(`searchProject?search_value=${payload}`).then((response) => {
                commit('setProject', response.data)
            }).catch(err => {
                console.log(err);
            });
        });
    },
    getProjectsResults: ({commit}, link) => {
        axios.get(link.url).then((response) => {
            commit('setProject', response.data)
        });
    },
    // store project in db
    storeProject({commit}, payload) {
        axios
            .post("projects", payload)
            .then((response) => {
            }).catch((error) => {
                if (error.response.status === 422) { // Validation error
                    commit('setErrors', error.response.data.errors);
                } else {
                    console.error("Error storing project:", error);
                }
            });
    },
     // update a project
     updateProject({commit}, payload) {
        axios.put(`projects/${payload.id}`, payload)
            .then((response) => {
            })
            .catch((error) => {
                if (error.response.status === 422) { // Validation error
                    commit('setErrors', error.response.data.errors);
                } else {
                    console.error("Error updating project:", error);
                }
        });
    },
     // delete project from db
    deleteProject({commit}, payload) {
        axios
            .delete("projects/" + payload.id)
            .then((response) => {
                console.log(
                    "project deleted successfully:",
                    response.data
                );
            })
            .catch((error) => {
                console.error("Error deleting project:", error);
            });

    }
   
}