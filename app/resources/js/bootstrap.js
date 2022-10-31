window._ = require('lodash');
window.moment = require('moment');
window.toaster = require('./toaster');
window.ClipboardJS = require('clipboard');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('flatpickr');
    require('./vendors/select2');

    const Tags = jQuery.fn.select2.amd.require('select2/data/tags');

    const _createTag = Tags.prototype.createTag;

    Tags.prototype.createTag = function(decorated, params) {
        const tag = _createTag(decorated, params);

        if (tag !== null) {
            tag.isCreateTag = true;
        }
    
        return tag;
    }
} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error?.response?.status !== 422) {
        toaster.error('Error' ,'An error occurred, please try again');
    }

    return Promise.reject(error);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
