import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
// import css file
import '@/assets/css/main.css'
import '@/assets/js/app.js'
 import '@/broadcast.js'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import moment from 'moment';

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: "182692280aefe2e9e4f1",
//     cluster: "eu",
//     encrypted: true,
//     forceTLS: false
// });

require('@/store/subscriber')

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/v1';

const app = createApp(App);

app.config.globalProperties.$filters = {
    myDate(date) {
        return moment(date).startOf('hour').fromNow();
    }
};
store.dispatch('auth/attempt',localStorage.getItem('token')).then(() => {
    app.use(store).use(router).mount('#app')
})


