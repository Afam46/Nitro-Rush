<template>
  <main id="shop" v-if="cars && parts && checkCars">
    <article class="items">
      <div class="item">
        <div style="width: 60%;">
          <p class="product-name market-product-name">{{ cars[0].name }}</p>
          <div style="position: relative; width: 40%; rotate: 90deg; margin: 0 auto">
            <img :src="`/storage/img/${(cars[0].name).toLowerCase()}_mask.png`"
            style="width: 100%;" :style="`${cars[0].color}`">
            <img :src="`/storage/img/${(cars[0].name).toLowerCase()}.png`"
            style="position: absolute; top: 0; left: 0; width: 100%;">
          </div>
        </div>
        <div class="info">
          <div class="price-car-market" style="width: 40%">
            <div class="price-text">
              Цена:
            </div>
            <div class="price-kybok-market">
              <p>{{ cars[0].price }}</p>
              <div class="kybok-market">
                <img src="./img/kybok.png" alt="">
              </div>
            </div>
          </div>
          <div class="lvl-rare" style="width: 20%">
            <p class="lvl">{{ parseInt(cars[0].lvl) }} ур.</p>
            <div :style="`background-color:var(--color${cars[0].rare})`" class="rare-scale"></div>
          </div>
        </div>
        <AtributesMarketCars :item="cars[0]"/>
        <div v-if="
        checkCars[0].car_id !== cars[0].id &&
        checkCars[1].car_id !== cars[0].id && buyCarCheck != cars[0].id"
        style="width: 100%;">
          <button v-if="balance >= cars[0].price" class="orange-btn btn-shop"
          @click="buyCar(cars[0].id,cars[0].price)">Купить</button>
          <button v-else class="disabled btn-shop">Купить</button>
        </div>
        <div v-else style="width: 100%;">
           <button class="disabled btn-shop">Куплено</button>
        </div>
      </div>
      <div class="main-items" v-if="checkParts">
        <div class="main-item" v-for="part in parts" :key="part.id">
          <p class="product-name-part">{{ part.name }}</p>
          <img src="./img/blue_car.png" alt="">
          <div class="info" style="width: 100%; margin: 10px auto;">
            <div class="price-car-market" style="width: 100%">
              <div class="price-kybok-market" style="border-radius: 10px 0 0 10px;">
                <p>{{ part.price }}</p>
                <div class="kybok-market">
                  <img src="./img/kybok.png" alt="">
                </div>
              </div>
            </div>
            <div class="price-lvl-shop">
              <div class="lvl" style="border-radius: 0 10px 10px 0;">{{ part.lvl }} ур.</div>
            </div>
          </div>
          <div style="width: 100%; height: 100%;
          display: flex; justify-content: center; align-items: center;">
            <img :src="part.img" alt="" style="width: 66%">
          </div>
          <AtributesMarketParts :item="part"/>
          <div v-if="
            checkParts[0].part_id !== part.id && buyPartCheck !== part.id &&
            checkParts[1].part_id !== part.id &&
            checkParts[2].part_id !== part.id" style="width: 100%;">
            <button v-if="balance >= part.price" class="orange-btn btn-shop" 
            @click="buyPart(part.id,part.price)">Купить</button>
            <button v-else class="disabled btn-shop">Купить</button>
          </div>
          <div v-else style="width: 100%;">
             <button class="disabled btn-shop">Куплено</button>
          </div>
        </div>
      </div>
      <div class="item">
        <div style="width: 60%">
          <p class="product-name market-product-name">{{ cars[1].name }}</p>
          <div style="position: relative; width: 40%; rotate: 90deg; margin: 0 auto">
            <img :src="`/storage/img/${(cars[1].name).toLowerCase()}_mask.png`"
            style="width: 100%;" :style="`${cars[1].color}`">
            <img :src="`/storage/img/${(cars[1].name).toLowerCase()}.png`"
            style="position: absolute; top: 0; left: 0; width: 100%;">
          </div>
        </div>
        <div class="info">
          <div class="price-car-market" style="width: 40%">
            <div class="price-text">
              Цена:
            </div>
            <div class="price-kybok-market">
              <p>{{ cars[1].price }}</p>
              <div class="kybok-market">
                <img src="./img/kybok.png" alt="">
              </div>
            </div>
          </div>
          <div class="lvl-rare" style="width: 20%">
            <p class="lvl">{{ parseInt(cars[1].lvl) }} ур.</p>
            <div :style="`background-color:var(--color${cars[1].rare})`" class="rare-scale"></div>
          </div>
        </div>
        <AtributesMarketCars :item="cars[1]"/>
        <div v-if="
        checkCars[0].car_id !== cars[1].id &&
        checkCars[1].car_id !== cars[1].id && buyCarCheck != cars[1].id"
        style="width: 100%;">
          <button v-if="balance >= cars[1].price" class="orange-btn btn-shop" 
          @click="buyCar(cars[1].id,cars[1].price)">Купить</button>
          <button v-else class="disabled btn-shop">Купить</button>
        </div>
        <div v-else style="width: 100%;">
           <button class="disabled btn-shop">Куплено</button>
        </div>
      </div>
    </article>
  </main>
</template>

<script>
import AtributesMarketCars from './components/AtributesMarketCars.vue';
import axios from 'axios';
import AtributesMarketParts from './components/AtributesMarketParts.vue';

export default{
  components:{AtributesMarketCars, AtributesMarketParts},
  data(){
    return{
      cars: null,
      parts: null,
      balance: 0,
      buyPartCheck: true,
      buyCarCheck: true,
      checkCars: null,
      checkParts: null,
    }
  },
  mounted(){
    this.getShopCars();
    this.getShopParts();
    this.getBalance();
    this.getCheckCars();
    this.getCheckParts();
  },
  methods:{
    getShopCars(){
      axios.get('/api/cars/shop').then(res => {
        this.cars = res.data;
      })
    },
    getShopParts(){
      axios.get('/api/parts/shop').then(res => {
        this.parts = res.data;
      })
    },
    getBalance(){
      axios.get('/api/user/balance').then(res => {
        this.balance = res.data;
      })
    },
    getCheckCars(){
      axios.get('/api/checkCars').then(res => {
        if(res.data.length == 1){
          res.data.push({car_id:-1});
          this.checkCars = res.data
        }else if(res.data.length > 1){
          this.checkCars = res.data
        }else{
          this.checkCars = [{car_id:-1},{car_id:-1}]
        }
      });
    },
    getCheckParts(){
      axios.get('/api/checkParts').then(res => {
        if(res.data.length == 1){
          res.data.push({part_id:-1},{part_id:-1});
          this.checkParts = res.data
        }else if(res.data.length == 2){
          res.data.push({part_id:-1});
          this.checkParts = res.data
        }else if(res.data.length == 3){
          this.checkParts = res.data
        }else{
          this.checkParts = [{part_id:-1},{part_id:-1},{part_id:-1}]
        }
      });
    },
    buyCar(carId, carPrice){
      if(this.balance >= carPrice){
        this.buyCarCheck = carId;
        axios.post('/api/cars/buyInShop',{
          id: carId,
          price: carPrice,
        }).then(res => {
          const text = document.querySelector('.balance').textContent
          document.querySelector('.balance').textContent = parseInt(text) - carPrice;
          this.getBalance();
          this.getCheckCars();
        });
      }
    },
    buyPart(partId, partPrice){
      if(this.balance >= partPrice){
        this.buyPartCheck = partId;
        axios.post('/api/parts/buyInShop',{
          id: partId,
          price: partPrice,
        }).then(res => {
          const text = document.querySelector('.balance').textContent
          document.querySelector('.balance').textContent = parseInt(text) - partPrice;
          this.getBalance();
          this.getCheckParts();
        });
      }
    },
  }
}
</script>

<style>
#shop{
  flex-grow: 1;
  width: 36%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin: 30px auto;
}
.items {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  flex-wrap: wrap;
}
.item {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  padding: 10px;
  border-radius: 10px;
}
.main-items {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  margin: 20px 0;
  align-items: stretch;
}
.main-item {
  width: 32%;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  padding: 5px;
  display: flex;
  align-self: stretch;
  align-items: center;
  flex-direction: column;
  border-radius: 10px;
}
.btn-shop{
  margin: 10px 0;
}
.price-lvl-shop{
  width: 60%;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.product-name{
  text-align: center;
  margin: 5px 0;
  margin-bottom: 15px;
}
.product-name-part{
  text-align: center;
  margin: 5px 0;
  margin-bottom: 15px;
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.4);
  border-radius: 10px;
  padding: 2px;
}
</style>