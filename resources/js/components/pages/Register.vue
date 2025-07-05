<template>
   <div style="width: 25%; margin: 0 auto;">
    <h2>Регистрация</h2>
    <input v-model="name" type="name" placeholder="name">
    <input v-model="email" type="email" placeholder="email">
    <input v-model="password" type="password" placeholder="password">
    <input v-model="password_confirm" type="password" placeholder="password_confirm">
    <input @click.prevent="register" type="submit" value="register" class="orange-btn">
  </div>
</template>

<script>
export default{
  data(){
    return{
      name: null,
      email: null,
      password: null,
      password_confirm: null,
      colors: ['red','brown','black','green','yellow','orange','orangered','blue'],
    }
  },
  methods:{
    getBalance(){
      axios.get('api/user/balance').then(res => {
        document.querySelector('.balance').textContent = res.data
      })
    },
    getRand(min, max){
      return Math.random() * (max - min) + min;
    },
    createNewCar(){
      axios.post('/api/cars/store', {
        name: 'New Car',
        img: '.',
        speed: Math.ceil(this.getRand(5, 20)),
        power: Math.ceil(this.getRand(25, 70)),
        color: this.colors[Math.round(Math.random()*8)]
      });
    },
    register(){
      axios.get('/sanctum/csrf-cookie').then(res => {
        axios.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirm
        }).then(res => {
          localStorage.setItem('isAuth', true);
          this.createNewCar();
          this.getBalance();
          this.$router.push({name: 'home'});
        });
      });
    }
  }
}
</script>