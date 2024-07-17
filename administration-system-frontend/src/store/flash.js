export default {
  namespaced: true,
    state: {
      message: '',
      type: ''
    },
    getters: {
      flashMessage(){
        return state.message
      },
      flashType(){
        return state.type
      }
    },
    mutations: {
      SET_FLASH_MESSAGE(state, payload) {
        state.message = payload.message;
        state.type = payload.type;
      },
      CLEAR_FLASH_MESSAGE(state) {
        state.message = '';
        state.type = '';
      }
    },
    actions: {
      setFlashMessage({ commit }, payload) {
        commit('SET_FLASH_MESSAGE', payload);
        setTimeout(() => {
          commit('CLEAR_FLASH_MESSAGE');
        }, 9000); // Clear the message after 9 seconds
      },

      clearFlashMessage({ commit }) {
        commit('CLEAR_FLASH_MESSAGE');
      }
    },
}

