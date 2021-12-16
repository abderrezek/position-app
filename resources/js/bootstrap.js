/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

document.addEventListener('turbo:before-fetch-request', (e) => {
    e.detail.fetchOptions.headers['X-Socket-ID'] = window.Echo.socketId();
});
