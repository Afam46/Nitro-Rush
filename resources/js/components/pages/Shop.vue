<template>
  <main id="market">
    <article id="products" v-if="cars" style="width: 100%;">
      <article class="product" v-for="car in cars" :key="car.id">
        <p>{{ car.name }}</p>
        <img src="./demoimg/blue_car.png" alt="" :style="`background-color:${car.color};`">
        <div class="info">
          <p>{{ car.price }}</p>
          <div>
            <p class="lvl">{{ parseInt(car.lvl) }} ур.</p>
            <div :style="`background-color:var(--color${car.rare})`" class="rare-scale"></div>
          </div>
        </div>
        <p>Продавец: {{ car.user.name }}</p>
        <button v-if="car.user_id === user_ID" class="orange-btn" @click="returnCar(car.id)">Снять c продажи</button>
        <div v-else style="width: 100%;">
          <button v-if="balance >= car.price" class="orange-btn" 
          @click="buy(car.id,car.price)">Купить</button>
          <button v-else class="disabled">Купить</button>
        </div>
      </article>
    </article>
  </main>
</template>

<script>
import axios from 'axios';

export default{
  data(){
      return{
        cars: null,
        balance: null,
      }
  },
  mounted(){
    this.getCars();
    this.getUser();
  },
  methods:{
    getCars(){
      axios.get('/api/cars').then(res => {
        this.cars = res.data;
      })
    },
    getUser(){
      axios.get('/api/user').then(res => {
        this.balance = res.data.balance;
      });
    },
    buy(carId, carPrice){
      if(this.balance >= carPrice){
        axios.post('/api/user/sellPlayer',{
          id: carId,
          price: carPrice,
          user_id: this.user_ID
        }).then(res => {
          const text = document.querySelector('.balance').textContent
          document.querySelector('.balance').textContent = parseInt(text) - carPrice;
          this.getCars();
          this.getUser();
        });
      }
    },
  }
}
</script>