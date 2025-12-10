import axios from 'axios';
window.axios = axios;

// Send cookies (for Sanctum first-party SPA auth)
window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Try to initialize CSRF cookie for Sanctum (safe to call on page load)
// This allows subsequent POST/login requests to be authenticated via cookie/token
axios.get('/sanctum/csrf-cookie').catch(() => {
    // ignore errors on bootstrap; dev server or backend might not be up yet
});
