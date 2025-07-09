<template>
  <AppHeader/>
  <router-view style="margin-bottom: 90px;"></router-view>
  <AppFooter/>
</template>

<script>
import axios from 'axios';
import AppHeader from './AppHeader.vue';
import AppFooter from './AppFooter.vue';
import router from '../router';

export default{
  components: {AppHeader, AppFooter},
  mounted(){
    //window.addEventListener('load', function() {
    //  router.push('/');
    //}),
    this.getBalance();
  },
  methods:{
    getBalance(){
      axios.get('api/user/balance').then(res => {
        if(res.data > 0){
          document.querySelector('.balance').textContent = res.data;
        }
      });
    },
  }
}
</script>

<style>
:root{
  --color1: green;
  --color2: blue;
  --color3: rgb(87, 0, 158);
  --color4: orange;
  --color5: red;
}
*{
  box-sizing: border-box;
}
html{
  height: 100%;
}
html, body{
  padding: 0;
  margin: 0;
  image-rendering: pixelated;
  background-color: #242C3B;
  color:white;
  cursor:default;
  font-family: 'Montserrat';
  font-weight: 400;
}
body{
  display: flex;
  flex-direction: column;
  min-height: 100%;
}
*::-webkit-scrollbar {
  width: 0;
}
*::-webkit-scrollbar-track {
  background: #242C3B;
}
*::-webkit-scrollbar-thumb {
  background-color: #4B4CED;
  border-radius: 5px;
}
main{
  flex-grow: 1;
  width: 30%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin: 0 auto;
}
@media screen and (max-width: 1250px) {
  main{
    width: 40%;
  }
}
@media screen and (max-width: 1000px) {
  main{
    width: 50%;
  }
}
@media screen and (max-width: 750px) {
  main{
    width: 62%;
  }
}
@media screen and (max-width: 600px) {
  main{
    width: 70%;
  }
}
@media screen and (max-width: 525px) {
  main{
    width: 80%;
  }
  .atributes{
    font-size: 16px;
  }
}
@media screen and (max-width: 460px) {
  main{
    width: 100%;
  }
  .prev {
    left: 5px;
  }
  .next {
    right: 5px;
  }
}
@media screen and (max-width: 370px) {
  .fuel-bg, .speed-bg, .power-bg, .level, .mod-bg, .rare{
    height: 50px;
  }
}
@media screen and (max-width: 340px) {
  .atributes{
    font-size: 13px;
  }
}
</style>