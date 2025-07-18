<template>
  <div class="footer-nav">
    <div class="footer-container">
      <nav>
        <router-link :to="{name: 'races'}" id="race-footer"
        :class="{'active': acId === 0}" @click="acId = 0">
          <img src="./pages/img/icon_race.png" style="width: 36%;">
        </router-link>
        <router-link :to="{name: 'home'}" id="home-footer"
        :class="{'active': acId === 1}" @click="acId = 1">
          <img src="./pages/img/icon_house.png">
        </router-link>
        <router-link :to="{name: 'market'}"
        :class="{'active': acId === 2}" @click="acId = 2">
          <img src="./pages/img/icon_market.png">
        </router-link>
        <router-link :to="{name: 'shop'}"
        :class="{'active': acId === 3}" @click="acId = 3">
          <img src="./pages/img/icon_shop.png">
        </router-link>
      </nav>
    </div>
  </div>
</template>

<script>
export default{
  data(){
    return{
      acId: 1,
    }
  },
}
</script>

<style scoped>
.footer-nav{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  position: fixed;
  bottom: 0;
  z-index: 1000;
}
.footer-container{
  width: 25%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  background: linear-gradient(to bottom left, #363E51, #181C24);
  padding: 10px;
  border-radius: 30px 30px 0 0;
  border-top: solid 2px #4B4CED;
}
nav{
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: stretch;
}
nav a{
  width: 20%;
  display: flex;
  justify-content: center;
  align-items: center;
  align-self: stretch;
  margin: 0 5px;
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,.4);
}
nav a img{
  width: 50%;
}
.active{
  background: linear-gradient(to bottom right, #37B6E9, #4B4CED);
}
@media screen and (max-width: 1250px) {
  .footer-container{
    width: 30%;
  }
}
@media screen and (max-width: 1000px) {
  .footer-container{
    width: 40%;
  }
}
@media screen and (max-width: 750px) {
  .footer-container{
    width: 50%;
  }
}
@media screen and (max-width: 600px) {
  .footer-container{
    width: 60%;
  }
}
@media screen and (max-width: 520px) {
  .footer-container{
    width: 100%;
  }
  nav a{
    width: 15%;
  }
}
@media screen and (max-width: 440px) {
  .footer-container{
    width: 100%;
  }
  nav a{
    width: 18%;
  }
}
</style>