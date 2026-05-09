<template>
   <div style="width: 25%; margin: 0 auto; display:flex; justify-content:center;">
    <div>
      <h2 style="text-align: center;">Регистрация</h2>
      <input v-model="name" type="name" placeholder="имя">
      <input v-model="email" type="email" placeholder="почта">
      <input v-model="password" type="password" placeholder="пароль">
      <input v-model="password_confirm" type="password"
      placeholder="подтверждение пароля">
      <input @click.prevent="register" type="submit" value="Зарегестрироваться" 
      class="orange-btn" style="margin-top: 10px;">
    </div>
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
    async getBalance(){

    const token = localStorage.getItem('auth_token');

    const res = await axios.get('/api/user/balance', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });

    document.querySelector('.balance').textContent = res.data;
},
    getRand(min, max){
      return Math.random() * (max - min) + min;
    },
    async register() {
    try {

        const response = await axios.post('/api/register', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirm
        });

        const token = response.data.token;

        console.log('NEW TOKEN:', token);

        localStorage.setItem('auth_token', token);

        await this.getBalance();

        this.$router.push({ name: 'home' });

    } catch (error) {
        console.error(error.response?.data || error);
    }
}
  }
}
</script>