window._ = require('lodash');


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key:"56f06aedd361f6cdf71e",
    encrypted: true,
    cluster: "ap2",
    wsHost:"127.0.0.1:6001",
    disableStats: true,
});


