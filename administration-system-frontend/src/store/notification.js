import axios from 'axios';

export default {
    state: {
        unread_notifications: {},
        all_notifications: {},
    },
    getters: {
        unread_notifications(state) {
            return state.unread_notifications;
        },
        all_notifications(state) {
            return state.all_notifications;
        },
    },
    mutations: {
        set_all_notifications: (state, data) => {
            state.all_notifications = data;
        },
        set_unread_notifications: (state, data) => {
            state.unread_notifications = data;
        },

    },
    actions: {
        getAllNotifications: (context) => {
            axios.get(`getAllNotifications`).then((response) => {
                context.commit('set_all_notifications', response.data)
            });
        },
        getUnreadNotifications: (context) => {
            axios.get(`getUnreadNotifications`).then((response) => {
                context.commit('set_unread_notifications', response.data)
            });
        },
        clearAllNotifications: (context) => {
            axios.get(`clearAllNotifications`).then((response) => {
                context.dispatch('getAllNotifications')
                
            });
        },
        markNotificationAsRead: (context, unreadData) => {
            axios.get(`markNotificationAsRead/${unreadData.id}`).then((response) => {
                context.dispatch('getUnreadNotifications')
               
            });
        },
       
    },
}