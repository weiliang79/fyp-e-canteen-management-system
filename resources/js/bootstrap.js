import _ from 'lodash';
window._ = _;

import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

// jQuery
import jQuery from 'jquery';
window.$ = jQuery;

// DataTables
import DataTable from 'datatables.net-bs5';
DataTable(window, window.$);

//sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;

//sweetalert2 bootstrap theme
window.SwalWithBootstrap = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary mx-3',
        cancelButton: 'btn btn-danger mx-3',
    },
    buttonsStyling: false,
});

// flatpickr
import flatpickr from 'flatpickr';
window.flatpickr = flatpickr;

// stripe js
import {loadStripe} from "@stripe/stripe-js";
window.loadStripe = loadStripe;

//dateFormat
import dateFormat from 'dateformat';
window.dateFormat = dateFormat;

// chart.js
import {Chart, registerables} from 'chart.js';

Chart.register(...registerables);

window.Chart = Chart;
