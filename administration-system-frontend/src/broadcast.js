import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "182692280aefe2e9e4f1",
    cluster: "eu",
    encrypted: true,
    forceTLS: false
});

