import axios from "axios";

export default {
  // retreive projects data from api 
  getProjects({commit,state}, page=1) {
    axios
        .get("projects")
        .then((response) => {
            console.log(response)
            commit('setProject', response.data.data)
            
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) { // Validation error
                console.log('yes')
                commit('setErrors', error.response.data.errors);
            } else {
                console.error("Error fetching projects:", error);
            }
        });
    },
    // search 
     // Search users
     searchProject({commit}, payload) {
        setTimeout(function() {
            console.log(1)
            axios.get(`searchProject?search_value=${payload}`).then((response) => {
                console.log(response.data.data)
                commit('setProject', response.data.data)
            }).catch(err => {
                console.log(err);
            });
        });
    },
    getProjectsResults: (context, link) => {
        axios.get(link.url).then((response) => {
            context.commit('set_projects', response.data.data)
        });
    },
    // store project in db
    storeProject({commit}, payload) {
        axios
            .post("projects", payload)
            .then((response) => {
                console.log(response.data);
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
                console.log(response);
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