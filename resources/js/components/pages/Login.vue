<template>
  <div style="width: 25%; margin: 0 auto; display: flex; justify-content:center;">
    <div>
        <h2 style="text-align: center">Авторизация</h2>
        <input v-model="email" type="email" placeholder="почта">
        <input v-model="password" type="password" placeholder="пароль">
        <input @click.prevent="login" type="submit" value="Войти" class="orange-btn"
        style="margin: 10px 0;">
        <router-link :to="{name: 'register'}">Нет аккаунта?</router-link>
    </div>
  </div>
</template>

<script>
export default{
  data(){
    return{
      email: null,
      password: null,
    }
  },
  methods:{
    getBalance(){
      axios.get('api/user/balance').then(res => {
        document.querySelector('.balance').textContent = res.data
      })
    },
   async login() {
    try {
    await axios.get('/sanctum/csrf-cookie');
    
    const response = await axios.post('/api/login', {
      email: this.email,
      password: this.password
    }, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      withCredentials: true
    });

    localStorage.setItem('auth_token', response.data.token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

    this.$router.push('/');

  } catch (error) {
    console.error('Full error:', error);

    const serverMessage = error.response?.data?.message;
    const errorMessage = serverMessage || 'Login failed';
    
    alert(`Error: ${errorMessage}`);
  }
}
  }
}
</script>