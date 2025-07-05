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
    login(){
      axios.get('/sanctum/csrf-cookie').then(res => {
        axios.post('/login', {
          email: this.email,
          password: this.password
        }).then(res => {
          localStorage.setItem('isAuth', true);
          this.getBalance();
          this.$router.push({name: 'home'})
        });
      });
    }
  }
}
</script>