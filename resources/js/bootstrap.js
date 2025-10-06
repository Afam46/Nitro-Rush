import axios from 'axios';
import router from './router';

window.axios = axios;

// БАЗОВЫЕ НАСТРОЙКИ
axios.defaults.baseURL = 'http://84.54.31.144';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

// УСТАНОВКА ТОКЕНА ПРИ ЗАГРУЗКЕ ПРИЛОЖЕНИЯ
const token = localStorage.getItem('auth_token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// ИНТЕРЦЕПТОР ДЛЯ АВТОРИЗАЦИИ
window.axios.interceptors.response.use(
  (response) => response,
  (err) => {
      if (err.response?.status === 401 || err.response?.status === 419) {
          const token = localStorage.getItem('auth_token');
          if (token) {
              localStorage.removeItem('auth_token');
              delete axios.defaults.headers.common['Authorization'];
          }
          router.push({ name: 'login' });
      }
      return Promise.reject(err);
  }
);

// ИНТЕРЦЕПТОР ДЛЯ ДОБАВЛЕНИЯ ТОКЕНА К КАЖДОМУ ЗАПРОСУ
window.axios.interceptors.request.use(
  (config) => {
      const token = localStorage.getItem('auth_token');
      if (token) {
          config.headers.Authorization = `Bearer ${token}`;
      }
      return config;
  },
  (error) => {
      return Promise.reject(error);
  }
);

// ECHO (если используется)
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: '84.54.31.144',
    wsPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws'],
    wsPath: '',
});