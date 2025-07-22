import axios from 'axios';
import router from './router';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.withCredentials = true;

window.axios.interceptors.response.use(
  (response) => response,
  (err) => {
    if (err.response?.status === 401 || err.response?.status === 419) {
      const token = localStorage.getItem('auth_token');
      if (token) {
        localStorage.removeItem('auth_token');
      }
      router.push({ name: 'login' });
    }
    return Promise.reject(err);
  }
);


import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: '31.129.107.235',
    wsPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws'],
    wsPath: '',
});