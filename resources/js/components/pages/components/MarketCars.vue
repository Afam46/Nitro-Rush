<template>
  <article id="products" v-if="cars" style="width: 100%;">
    <article class="product" v-for="car in cars" :key="car.id">
      <p>{{ car.name }}</p>
      <img src="../demoimg/blue_car.png" alt="" :style="`background-color:${car.color};`">
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
</template>

<script>
import axios from 'axios';

export default{
  data(){
      return{
        cars: null,
        balance: null,
        user_ID: null,
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
        this.user_ID = res.data.id;
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
    returnCar(carId){
      axios.post('/api/cars/returnCar',{id: carId});
      this.getCars();
    }
  }
}
</script>

<style>
#products{
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
}
.product{
  padding: 10px;
  width: 90%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin-top: 40px;
  border-radius: 10px;
  box-shadow: 0px 0px 30px rgb(65, 65, 65);;
}
.orange-btn{
  width: 100%;
  border: none;
  background-color: orangered;
  border-radius: 10px;
  color: white;
  font-size: 20px;
  padding: 10px 0;
  cursor: pointer;
  text-align: center;
}
.disabled{
  width: 100%;
  border: none;
  background-color: rgb(87, 87, 87);
  border-radius: 10px;
  color: white;
  font-size: 20px;
  padding: 10px 0;
}
.info{
  margin: 10px 0;
  display: flex;
  justify-content: space-between;
  width: 80%;
}
.lvl{
  background-color: orangered;
  color: white;
  font-size: 20px;
  padding: 0 5px;
  border-radius: 10px;
}
.rare-scale{
  height: 7px;
  border-radius: 10px;
  width: 60%;
  margin: 0 auto;
  margin-top: 5px;
}
</style>