<template>
  <body>
    <AppHeader/>
    <router-view></router-view>
  </body>
</template>

<script>
import axios from 'axios';
import AppHeader from './AppHeader.vue';

export default{
  components: {AppHeader},
  mounted(){
    this.getBalance();
  },
  methods:{
    getBalance(){
      axios.get('api/user/balance').then(res => {
        document.querySelector('.balance').textContent = res.data
      })
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
</style>