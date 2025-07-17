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
      colors: [
        'filter: brightness(0) saturate(100%) invert(30%) sepia(16%) saturate(2713%) hue-rotate(47deg) brightness(96%) contrast(97%);',
        'filter: brightness(0) saturate(100%) invert(69%) sepia(84%) saturate(2581%) hue-rotate(19deg) brightness(101%) contrast(97%);',
        'filter: brightness(0) saturate(100%) invert(44%) sepia(99%) saturate(562%) hue-rotate(358deg) brightness(98%) contrast(94%);',
        'filter: brightness(0) saturate(100%) invert(20%) sepia(100%) saturate(6760%) hue-rotate(348deg) brightness(66%) contrast(105%);',
        'filter: brightness(0) saturate(100%) invert(11%) sepia(86%) saturate(4231%) hue-rotate(241deg) brightness(82%) contrast(130%);'
      ],
      names: ['Aurora', 'Prism']
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
      const nameNa = this.names[Math.round(Math.random()*1)]
      axios.post('/api/cars/store', {
        name: nameNa,
        speed: Math.ceil(this.getRand(30, 40)),
        power: Math.ceil(this.getRand(30, 40)),
        color: this.colors[Math.round(Math.random()*3)],
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