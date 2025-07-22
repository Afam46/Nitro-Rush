<template>
  <header ref="headerRef" :class="{ 'out': isScrolledDown }">
    <div class="header-container">
    <button @click="showMenu" style="cursor: pointer; border: none; background: transparent;">
      <img src="./pages/img/icon_menu.png" alt="">
    </button>
    <nav class="menu">
      <router-link :to="{name: 'login'}" @click="showMenu">Войти</router-link>
      <router-link :to="{name: 'register'}" @click="showMenu">Регистрация</router-link>
      <a style="cursor: pointer;" @click.prevent="logout" @click="showMenu">Выйти</a>
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <p style="color: gray;">Nitro Rush<br>v 1.0.0</p>
        <p style="color: gray;">by Afam</p>
      </div>
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
      open: false,
      isScrolledDown: false,
      scrollPrev: 0
    }
  },
  mounted() {
    window.addEventListener('scroll', () => this.handleScroll())
  },
  beforeDestroy() {
    window.removeEventListener('scroll', () => this.handleScroll())
  },
  methods:{
    async logout() {
  try {
    const response = await axios.post('/api/logout', {}, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
        'Accept': 'application/json'
      },
      withCredentials: true
    });
    
    localStorage.removeItem('auth_token');
    this.$router.push('/login');
  } catch (error) {
    console.error('Logout error:', error.response);
    localStorage.removeItem('auth_token');
    window.location.href = '/login';
  }
},
    showMenu(){
      if(this.open){
        document.querySelector('.menu').style.top = '-120svh';
        this.open = false;
      }else{
        document.querySelector('.menu').style.top = 0;
        this.open = true;
      }
    },
    handleScroll() {
      const scrolled = window.scrollY
      if (scrolled > 36 && scrolled > this.scrollPrev) {
        this.isScrolledDown = true
      } else {
        this.isScrolledDown = false
      }
      this.scrollPrev = scrolled
    }
  },
}
</script>

<style scoped>
header{
  margin-bottom: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  position: sticky;
  top: 0;
  transition: transform 0.3s ease;
  z-index: 1000;
}
.out {
  transform: translateY(-100%);
}
.header-container{
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 25%;
  position: relative;
  background: linear-gradient(to bottom left, #363E51, #181C24);
  padding: 10px 20px;
  border-radius: 0 0 30px 30px;
  border-bottom: solid 2px #4B4CED;
}
.menu{
  top: -120svh;
  position: absolute;
  transition: .6s;
  background: linear-gradient(to top left, #353F54, #222834);
  border-radius: 20px;
  z-index: 1200;
  width: 80%;
  height: 100svh;
  right: 0;
  padding: 20px;
  display: flex;
  flex-direction: column;
  box-shadow: -40px 0 100px rgba(0,0,0,0.8);
}
.menu a{
  box-shadow: 0 0 10px rgba(0,0,0,0.4);
  margin-bottom: 20px;
  border-radius: 10px;
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
  font-size: 18px;
}

@media screen and (max-width: 1250px) {
  .header-container{
    width: 35%;
  }
}
@media screen and (max-width: 1000px) {
  .header-container{
    width: 45%;
  }
}
@media screen and (max-width: 750px) {
  .header-container{
    width: 55%;
  }
}
@media screen and (max-width: 600px) {
  .header-container{
    width: 65%;
  }
}
@media screen and (max-width: 520px) {
  .header-container{
    width: 100%;
  }
}
@media screen and (max-width: 430px) {
  .header-container{
    width: 100%;
  }
}
</style>