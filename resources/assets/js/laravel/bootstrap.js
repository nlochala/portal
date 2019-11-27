window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// Already included in Dashmix Core JS
/*
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}
*/

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLC: true
// });
//
// // window.Echo.private(`message.${message}`)
// //     .listen('ParentMessageSent', (data) => {
// //         alert(JSON.stringify(data));
// //     });
//
// var channel = Echo.channel('my-channel');
// channel.listen('.my-event', function(data) {
//     alert(JSON.stringify(data));
// });
// SweetAlert
import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

const SwalToast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer),
            toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// SwalToast.fire({
//     icon: data.icon,
//     title: data.text,
// });

var user_uuid = document.getElementById('authenticated_user_uuid').value;
var user_id = document.getElementById('authenticated_user_id').value;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    disableStats: true,
    encrypted: true,
    // cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    // forceTLS: true
});

window.Echo.private('employees');

window.Echo.private('guardians');

window.Echo.private('students');

window.Echo.private('all');

window.Echo.private('user.' + user_uuid)
    .listen('ParentMessageSent', (data) => {
        SwalToast.fire({
            title: data.title,
            icon: data.icon,
            text: data.text,
        })
    })
    .notification((data) => {
        SwalToast.fire({
            title: data.title,
            icon: data.icon,
            text: data.text,
        })
    });


