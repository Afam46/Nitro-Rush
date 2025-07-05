import axios from 'axios';
import router from './router';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
window.axios.interceptors.response.use({}, err => {
  if(err.response.status === 401 || err.response.status === 419){
    const token = localStorage.getItem('isAuth')
    if(token){
      localStorage.removeItem('isAuth');
    }
  }
  router.push({name: 'login'});
});