<template>
  <head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  </head>
  <body>
    <AppHeader/>
    <router-view></router-view>
    <AppFooter/>
  </body>
</template>

<script>
import axios from 'axios';
import AppHeader from './AppHeader.vue';
import AppFooter from './AppFooter.vue';

export default{
  components: {AppHeader, AppFooter},
  mounted(){
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
  height: 100svh;
  overflow-x: hidden
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
</style>