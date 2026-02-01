import axios from 'axios';
import router from './router';

window.axios = axios;

// Базовая конфигурация
axios.defaults.baseURL = '';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

// Получаем CSRF cookie при загрузке
async function initializeCsrfToken() {
    try {
        // Очистим любые старые cookies
        document.cookie.split(";").forEach(function(c) {
            document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
        });
        
        // Получаем новый CSRF token
        await axios.get('/sanctum/csrf-cookie', {
            withCredentials: true,
            headers: {
                'Accept': 'application/json',
            }
        });
        
        console.log('✅ CSRF cookie получен');
    } catch (error) {
        console.warn('⚠️ Не удалось получить CSRF cookie:', error.message);
        // Для localhost иногда можно работать без CSRF
    }
}

// Инициализируем при загрузке
initializeCsrfToken();

// Interceptors (ваш существующий код)
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

// ECHO - ИСПРАВЬТЕ WS_HOST!
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY || 'app-key-12345',
    wsHost: import.meta.env.VITE_REVERB_HOST || '127.0.0.1',
    wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
    wsPath: '',
});