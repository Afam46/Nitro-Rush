<template>
  <header>
    <nav class="menu">
      <input type="checkbox" id="burger-checkbox" class="burger-checkbox">
      <label for="burger-checkbox" class="burger"></label>
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
  </header>
</template>

<script>
export default{
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
  display: flex;
  justify-content: center;
  width: 100%;
}
.balance-block{
  margin-top: 10px;
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
nav a:hover:not(.active){
  text-decoration:underline solid 1px white;
}
.active{
  border: solid 2px rgb(0, 0, 0);
  cursor: default;
}
.burger-checkbox {
  position: absolute;
  visibility: hidden;
}
.burger {
  position: relative;
  z-index: 30;
  cursor: pointer;
  display: block;
  position: relative;
  border: none;
  background: transparent;
  width: 40px;
  height: 26px;
}
.burger::before,
.burger::after {
  content: '';
  left: 0;
  position: absolute;
  display: block;
  width: 100%;
  height: 4px;
  border-radius: 10px;
  background: #000;
}
.burger::before {
  top: 0;
  box-shadow: 0 11px 0 #000;
  transition: box-shadow .3s .15s, top .3s .15s, transform .3s;
}
.burger::after {
  bottom: 0;
  transition: bottom .3s .15s, transform .3s;
}
.burger-checkbox:checked + .burger::before {
  top: 11px;
  transform: rotate(45deg);
  box-shadow: 0 6px 0 rgba(0,0,0,0);
  transition: box-shadow .15s, top .3s, transform .3s .15s;
}
.burger-checkbox:checked + .burger::after {
  bottom: 11px;
  transform: rotate(-45deg);
  transition: bottom .3s, transform .3s .15s;
}
.menu-list {
  top: 0;
  position: absolute;
  display: grid;
  gap: 12px;
  padding: 42px 0;
  margin: 0;
  background: rgb(87, 87, 87);
  list-style-type: none;
  transform: translateX(-200%);
  z-index: 20;
  transition: .3s;
  width: 200px;
}
.menu-item {
  display: block;
  padding: 8px;
  color: white;
  font-size: 18px;
  text-align: center;
  text-decoration: none;
}
.menu-item:hover {
  background: rgba(255,255,255,.2)
}
.burger-checkbox:checked ~ .menu-list {
  transform: translateY(0);
}
</style>