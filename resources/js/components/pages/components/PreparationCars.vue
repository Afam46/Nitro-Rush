<template>
  <div v-if="cars && race" style="width: 100%">
    <p style="text-align: center; margin: 20px 0 -30px 0;
    font-size: 20px;">Выберите тачку</p>
    <article class="car" v-for="car in cars" :key="car.id">
      <p class="car-gar-name">{{ car.name }}</p>

      <div style="width: 40%; rotate: 90deg">
      <div style="position: relative; width: 100%">
        <img :src="`/storage/img/${(car.name).toLowerCase()}_mask.png`"
        style="width: 100%;" :style="car.color">
        <img :src="`/storage/img/${(car.name).toLowerCase()}.png`"
        style="position: absolute; top: 0; left: 0; width: 100%;">
      </div>
      </div>
      
      <div class="statas"
      :style="car.lvl < race.min_lvl ? '':'border: 1px solid #4B4CED'">
        <p>Всего игр: {{ car.quantity }}</p>
        <p>Побед: {{ car.wins }}</p>
        <p>Проигрышей: {{ car.quantity - car.wins }}</p>
        <p>Процент побед: {{car.quantity > 0 ?
        Math.round((car.wins/car.quantity).toFixed(2) * 100) + '%'
        : 100 + '%'}}</p>
        <div class="atributes-market" style="margin-top: 20px">
        <div class="atribute-market">
          <div class="speed-bg-car">
            <img src="../img/speed.png" alt="" style="width: 90%">
          </div>
          <p>{{ Math.round(car.speed * (car.rare/2)) }}</p>
        </div>
        <div class="atribute-market">
          <div class="fuel-bg-car">
            <img src="../img/fuel.png" alt="">
          </div>
          <p>{{ car.fuel }}/{{ car.fuel_max }}</p>
        </div>
        <div class="atribute-market">
          <div class="power-bg-car">
            <img src="../img/power.png" alt="" style="width: 90%">
          </div>
          <p>{{ Math.round(car.power * (car.rare/2)) }}</p>
        </div>
      </div>
      </div>
      <button v-if="car.lvl < race.min_lvl" class="disabled">
        Недостаточный уровень
      </button>
      <button v-else-if="car.fuel < race.price" class="disabled">
        Не достаточно бензика
      </button>
      <button v-else @click="startRace(car.id, race.price)" class="orange-btn">
        Выбрать
      </button>
    </article>
  </div>
</template>

<script>
import axios from 'axios'
import router from '../../../router'

export default{
  data(){
    return{
      cars: null,
      race: null,
      raceId: this.$route.query.id,
    }
  },
  mounted(){
    this.getCars();
    this.getRace();
    this.getBalance();
  },
  methods:{
    getCars(){
      axios.get('/api/cars/race').then(res => {
        this.cars = res.data
      });
    },
    getRace(){
      axios.get(`/api/races/show/${this.raceId}`).then(res => {
        this.race = res.data
      })
    },
    startRace(carId, price){
      axios.post('/api/cars/startRace', {id: carId, price: price});
      router.push({path: '/raceGame', query:{raceId:this.raceId, carId:carId}});
    },
    getBalance(){
      axios.get('/api/user/balance').then(res => {
        document.querySelector('.balance').textContent = res.data;
      });
    }
  }
}
</script>

<style>
.statas{
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  margin: 10px 0;
  padding: 20px;
  width: 100%;
}
</style>