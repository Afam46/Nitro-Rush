<template>
  <div v-if="cars && race" style="width: 100%">
    <h1 style="text-align: center;">Выберите тачку</h1>
    <article class="car" v-for="car in cars" :key="car.id">
      <p>{{ car.name }}</p>
      <img src="../demoimg/blue_car.png" alt="" :style="`background-color:${car.color};`">
      <div class="statas">
        <p>Всего игр: {{ car.quantity }}</p>
        <p>Побед: {{ car.wins }}</p>
        <p>Проигрышей: {{ car.quantity - car.wins }}</p>
        <p>Процент побед: {{car.quantity > 0 ?
        Math.round((car.wins/car.quantity).toFixed(2) * 100) + '%'
        : 100 + '%'}}</p>
        <p>Скорость: {{ Math.round(car.speed * (car.rare/2)) }}</p>
        <p>Мощность: {{ Math.round(car.power * (car.rare/2)) }}</p>
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
      raceId: this.$route.params.id,
    }
  },
  mounted(){
    this.getCars();
    this.getRace();
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
      router.push({name: 'raceGame', params:{raceId:this.raceId, carId:carId}});
    }
  }
}
</script>

<style>
.statas{
  border: solid 1px black;
  padding: 20px;
  width: 100%;
}
</style>