<template>
  <header>
    <div class="header-container">
    <button @click="nice = true" style="cursor: pointer;">
      <img src="./pages/img/icon_menu.png" alt="">
    </button>
    <nav class="menu" v-if="nice">
      <ul class="menu-list">
          <li><router-link :to="{name: 'races'}">Гонки</router-link></li>
          <li><router-link :to="{name: 'home'}">Гараж</router-link></li>
          <li><router-link :to="{name: 'market'}">Рынок</router-link></li>
          <li><router-link :to="{name: 'shop'}">Магазин</router-link></li>
          <li><router-link :to="{name: 'login'}">Войти</router-link></li>
          <li><router-link :to="{name: 'register'}">Регистрация</router-link></li>
          <li><a style="cursor: pointer;" @click.prevent="logout">Выйти</a></li>
      </ul>
    </nav>
    <div>
      <div class="balance-block">
        <span class="balance">0</span>
        <div class="kybok">
          <img src="./pages/img/kybok.png" alt="">
        </div>
      </div>
    </div>
    </div>
  </header>
</template>

<script>
export default{
  data(){
    return{
      nice: false
    }
  },
  methods:{
    logout(){
      axios.post('/logout').then(res => {
        localStorage.removeItem('isAuth');
        this.$router.push({name: 'login'})
      })
    },
  }
}
</script>

<style>
header{
  padding-top: 20px;
  margin-bottom: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
}
.header-container{
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 25%;
}
.balance-block{
  display: flex;
  align-items: stretch;
}
.balance{
  box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
  border-radius: 10px 0 0 10px;
  padding: 6px;
  align-self: stretch;
}
.kybok{
  box-shadow: 0 0 10px rgba(0,0,0,0.4);
  background: linear-gradient(to bottom right, #353F54, #222834);
  border-radius: 0 10px 10px 0;
  display: flex;
  width: 40px;
  justify-content: center;
  align-items: center;
  align-self: stretch;
}
.kybok img{
  width: 80%;
}
nav{
  width: 20%;
  margin-top: 10px;
}
nav a{
  padding: 10px;
  color: white;
  font-size: 18px;
}
</style>