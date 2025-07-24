<template>
  <article id="products" v-if="parts" style="width: 100%;">
    <article class="product" v-for="part in parts" :key="part.id">
      <p class="market-product-name">{{ part.name }}</p>
      <div style="width: 100%; height: 100%; margin: 16px 0; min-height: 120px;
        display: flex; justify-content: center; align-items: center;">
        <img :src="part.img" alt="" style="width: 50%">
      </div>
      <div class="info">
        <div class="price-car-market">
          <div class="price-text" style="padding: 10px 6px;">
            Цена:
          </div>
          <div class="price-kybok-market">
            <p>{{ part.price }}</p>
            <div class="kybok-market">
              <img src="../img/kybok.png" alt="">
            </div>
          </div>
        </div>
        <p class="lvl">{{ parseInt(part.lvl) }} ур.</p>
      </div>
      <div class="atributes-market">
        <div class="atribute-market">
          <div class="speed-bg-car">
            <img src="../img/speed.png" alt="">
          </div>
          <p>+{{ part.speed }}</p>
        </div>
        <div class="atribute-market">
          <div class="fuel-bg-car">
            <img src="../img/fuel.png" alt="">
          </div>
          <p>+{{ part.fuel }}</p>
        </div>
        <div class="atribute-market">
          <div class="power-bg-car">
            <img src="../img/power.png" alt="">
          </div>
          <p>+{{ part.power }}</p>
        </div>
      </div>
      <p class="seller">Продавец: {{ part.user.name }}</p>
      <button v-if="part.user_id === user_ID" class="orange-btn btn-market"
      @click="returnPart(part.id)">Снять c продажи</button>
      <div v-else style="width: 100%;">
        <button v-if="balance >= part.price && !cd"
        class="orange-btn btn-market" 
        @click="buy(part.id,part.price)">Купить</button>
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
        parts: null,
        balance: null,
        user_ID: null,
        cd: false,
      }
  },
  mounted(){
    this.getParts();
    this.getUser();
    window.Echo.channel('update-part').listen('UpdatePart', () => {
      this.getParts();
      this.getUser();
    });
  },
  methods:{
    getParts(){
      axios.get('/api/parts').then(res => {
        this.parts = res.data;
        this.cd = false;
      })
    },
    getUser(){
      axios.get('/api/user').then(res => {
        this.balance = res.data.balance;
        this.user_ID = res.data.id;
        document.querySelector('.balance').textContent = this.balance;
      });
    },
    buy(partId, partPrice){
      if(this.balance >= partPrice){
        this.cd = true;
        axios.post('/api/user/sellPlayerPart',{
          id: partId,
          price: partPrice,
          user_id: this.user_ID
        }).then(res => {
          this.balance -= partPrice;
          document.querySelector('.balance').textContent = this.balance;
          this.getUser();
        });
      }
    },
    returnPart(partId){
      axios.post('/api/parts/returnPart',{id: partId});
    }
  }
}
</script>