<template>
  <div style="width: 25%; margin: 0 auto;">
    <h2>Авторизация</h2>
    <input v-model="email" type="email" placeholder="email">
    <input v-model="password" type="password" placeholder="password">
    <input @click.prevent="login" type="submit" value="login" class="orange-btn">
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