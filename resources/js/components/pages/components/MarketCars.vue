<template>
  <article id="products" v-if="cars" style="width: 100%;">
    <article class="product" v-for="car in cars" :key="car.id">
      <p class="market-product-name">{{ car.name }}</p>
      
      <div style="width: 40%; rotate: 90deg;">
        <div style="position: relative; width: 100%">
          <img :src="`/storage/img/${(car.name).toLowerCase()}_mask.png`"
          style="width: 100%;" :style="car.color">
          <img :src="`/storage/img/${(car.name).toLowerCase()}.png`"
          style="position: absolute; top: 0; left: 0; width: 100%;">
        </div>
      </div>

      <div class="info">
        <div class="price-car-market">
          <div class="price-text">
            Цена:
          </div>
          <div class="price-kybok-market">
            <p>{{ car.price }}</p>
            <div class="kybok-market">
              <img src="../img/kybok.png" alt="">
            </div>
          </div>
        </div>
        <div class="lvl-rare" :style="
        String(parseInt(car.lvl)).length > 1 ? 'width: 29%;':''">
          <p class="lvl">{{ parseInt(car.lvl) }} ур.</p>
          <div :style="`background-color:var(--color${car.rare})`" class="rare-scale"></div>
        </div>
      </div>
      <div class="atributes-market">
        <div class="atribute-market">
          <div class="speed-bg-car">
            <img src="../img/speed.png" alt="">
          </div>
          <p>{{ Math.round(car.speed * (car.rare/2)) }}</p>
        </div>
        <div class="atribute-market">
          <div class="fuel-bg-car">
            <img src="../img/fuel.png" alt="">
          </div>
          <p>{{ car.fuel_max }}</p>
        </div>
        <div class="atribute-market">
          <div class="power-bg-car">
            <img src="../img/power.png" alt="">
          </div>
          <p>{{ Math.round(car.power * (car.rare/2)) }}</p>
        </div>
      </div>
      <p class="seller">Продавец: {{ car.user.name }}</p>
      <button v-if="car.user_id === user_ID" class="orange-btn btn-market"
      @click="returnCar(car.id)">Снять c продажи</button>
      <div v-else style="width: 100%;">
        <button v-if="balance >= car.price && cd !== car.id"
        class="orange-btn btn-market" 
        @click="buy(car.id,car.price)">Купить</button>
        <button v-else class="disabled btn-market">Купить</button>
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
        cd: null,
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
        this.cd = null;
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
        this.cd = carId;
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
.product img{
  width: 80%;
}
.product{
  padding: 10px;
  width: 75%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin-top: 40px;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
}
.orange-btn{
  width: 100%;
  border: none;
  background: linear-gradient(to bottom right, #37B6E9, #4B4CED);
  border-radius: 10px;
  color: white;
  font-size: 18px;
  padding: 10px 0;
  cursor: pointer;
  text-align: center;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
}
.disabled{
  width: 100%;
  border: none;
  background: linear-gradient(to bottom right, #353F54, #222834);
  border-radius: 10px;
  color: white;
  font-size: 18px;
  padding: 10px 0;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
}
.info{
  margin: 20px 0;
  display: flex;
  justify-content: space-between;
  width: 80%;
}
.lvl{
  background: linear-gradient(to bottom right, #37B6E9, #4B4CED);
  color: white;
  font-size: 18px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px 8px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
}
.rare-scale{
  height: 7px;
  border-radius: 10px;
  width: 60%;
  margin: 0 auto;
  margin-top: 5px;
}
.atributes-market {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}
.atribute-market {
  width: 20%;
  text-align: center;
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.4);
  border-radius: 10px;
}
.atribute-market:nth-child(2){
  margin: 0 10px 0 10px;
}
.speed-bg-car {
  background-color:#353F54;
  box-shadow: 0 0 10px rgba(0,0,0,0.4);
  height: 40px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
}
.fuel-bg-car {
  background-color:#353F54;
  box-shadow: 0 0 10px rgba(0,0,0,0.4);
  height: 40px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
}
.fuel-bg-car img{
  width: 55%;
}
.power-bg-car {
  background-color:#353F54;
  box-shadow: 0 0 10px rgba(0,0,0,0.4);
  height: 40px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
}
.price-car-market{
  display: flex;
  justify-content: space-between;
  align-items: stretch;
  border-radius: 10px;
  width: 70%;
}
.kybok-market{
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 2px;
  width: 22%;
}
.price-kybok-market{
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  border-radius: 0 10px 10px 0;
  align-items: center;
  align-self: stretch;
  width: 100%;
}
.price-text{
  box-shadow: 0 0 10px rgba(0,0,0,0.4);
  background: linear-gradient(to bottom right, #353F54, #222834);
  border-radius: 10px 0 0 10px;
  display: flex;
  padding: 0 6px;
  justify-content: center;
  align-items: center;
  align-self: stretch;
}
.lvl-rare{
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.4);
  border-radius: 10px;
  width: 24%;
}
.seller{
  margin-top: 15px;
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.4);
  border-radius: 10px;
  padding: 5px 10px;
}
.btn-market{
  margin: 10px 0;
}
.market-product-name{
  background: linear-gradient(to bottom right, #37B6E9, #4B4CED);
  margin-top: 5px;
  margin-bottom: 15px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  border-radius: 10px;
  padding: 5px 10px;
}
</style>