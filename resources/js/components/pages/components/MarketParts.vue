<template>
  <article id="products" v-if="parts" style="width: 100%;">
    <article class="product" v-for="part in parts" :key="part.id">
      <p>{{ part.name }}</p>
      <img src="../demoimg/part.png" alt="">
      <div class="info">
        <p>{{ part.price }}</p>
        <p class="lvl">{{ parseInt(part.lvl) }} ур.</p>
      </div>
      <p>Продавец: {{ part.user.name }}</p>
      <button v-if="car.user_id === user_ID" class="orange-btn" @click="returnCar(car.id)">Снять c продажи</button>
      <div v-else style="width: 100%;">
        <button v-if="balance >= car.price" class="orange-btn" 
        @click="buy(car.id,car.price)">Купить</button>
        <button v-else class="disabled">Купить</button>
      </div>
    </article>
  </article>
</template>

<script>
import axios from 'axios';

export default{
  data(){
      return{
        parts: null,
        balance: null,
        user_ID: null,
      }
  },
  mounted(){
    this.getParts();
    this.getUser();
  },
  methods:{
    getParts(){
      axios.get('/api/parts').then(res => {
        this.parts = res.data;
      })
    },
    getUser(){
      axios.get('/api/user').then(res => {
        this.balance = res.data.balance;
        this.user_ID = res.data.id;
      });
    },
    buy(partId, partPrice){
      if(this.balance >= partPrice){
        axios.post('/api/user/sellPlayerPart',{
          id: partId,
          price: partPrice,
          user_id: this.user_ID
        }).then(res => {
          const text = document.querySelector('.balance').textContent
          document.querySelector('.balance').textContent = parseInt(text) - partPrice;
          this.getParts();
          this.getUser();
        });
      }
    },
    returnPart(partId){
      axios.post('/api/parts/returnPart',{id: partId});
      this.getParts();
    }
  }
}
</script>